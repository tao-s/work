<?php namespace App;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\CustomerConfirmation;
use Illuminate\Http\Request;

class Customer extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    protected $table = 'customers';
    protected $fillable = ['is_activated'];
    protected $dates = ['deleted_at'];

    // trait を使う。
    use Authenticatable;
    use CanResetPassword;
    use SoftDeletes;

    public function profile()
    {
        return $this->hasOne('App\CustomerProfile');
    }

    public function application()
    {
        return $this->hasMany('App\Application');
    }

    public function confirmation()
    {
        return $this->hasMany('App\CustomerConfirmation');
    }

    public function status()
    {
        $confirm = CustomerConfirmation::where('customer_id', $this->id)->whereNotNull('confirmed_at');

        if ($confirm->count() > 0) {
            return 'active';
        }

        if ($this->is_activated) {
            return 'active';
        }

        return 'inactive';
    }

    public static function search(Request $req)
    {
        $q = self::select('*')->with('profile');

        $mail = $req->mail_magazine_flag;
        if (!empty($mail)) {
            $q->whereHas('profile', function($q) use ($mail) {
                $flag = $mail == 'true' ? true : false;
                $q->where('mail_magazine_flag', $flag);
            });
        }

        $scout = $req->scout_mail_flag;
        if (!empty($scout)) {
            $q->whereHas('profile', function($q) use ($scout) {
                $flag = $scout == 'true' ? true : false;
                $q->where('scout_mail_flag', $flag);
            });
        }

        $age_from = $req->age_from;
        $age_to = $req->age_to;
        if ($age_from || $age_to) {
            if ($age_from && $age_to) {
                $year_to = Carbon::now('Asia/Tokyo')->subYears($age_from)->format('Y-12-31');
                $year_from = Carbon::now('Asia/Tokyo')->subYears($age_to)->format('Y-01-01');
                $q->whereHas('profile', function($q) use ($year_from, $year_to) {

                    $q->whereBetween('birthday', [$year_from, $year_to]);
                });
            }

            if ($age_from && !$age_to) {
                $year_from = Carbon::now('Asia/Tokyo')->subYears($age_from)->format('Y-m-d');
                $q->whereHas('profile', function($q) use ($year_from) {
                    $q->where('birthday', '<=', $year_from);
                });
            }

            if (!$age_from && $age_to) {
                $year_to = Carbon::now('Asia/Tokyo')->subYears($age_to)->format('Y-m-d');
                $q->whereHas('profile', function($q) use ($year_to) {
                    $q->where('birthday', '>=', $year_to);
                });
            }

        }

        $freeword = $req->freeword;
        if ($freeword) {
            $like = '%'.$freeword.'%';
            $q->where(function($q) use ($like) {
                $q->where('email', 'LIKE', $like)
                ->orWhereHas('profile', function($q) use ($like) {
                    $q->where(function($q) use ($like) {
                        $q->orWhere('username', 'LIKE', $like)
                            ->orWhere('school_name', 'LIKE', $like)
                            ->orWhere('job_record', 'LIKE', $like)
                            ->orWhere('qualification', 'LIKE', $like)
                            ->orWhere('introduction', 'LIKE', $like)
                            ->orWhere('future_plan', 'LIKE', $like)
                            ->orWHere('skill', 'LIKE', $like);
                    });
                });
            });
        }

        return $q;
    }

    public function saveWithProfile($data = null)
    {
        $ret = DB::transaction(function() use ($data) {
            $ret1 = $this->save();
            $profile = new CustomerProfile();
            $profile->customer_id = $this->id;
            $profile->save();

            $profile->industry_types()->detach($profile->industry_types()->getRelatedIds());

            if (isset($data['industry_types'])) {
                $profile->industry_types()->attach(array_filter($data['industry_types']));
                unset($data['industry_types']);
            }

            $profile->occupation_categories()->detach($profile->occupation_categories()->getRelatedIds());

            if (isset($data['occupation_category'])) {
                for ($i = 0; $i <= 2; $i++) {
                    if (!empty($data['occupation_category'][$i])) {
                        $profile->occupation_categories()->attach(
                            $data['occupation_category'][$i],
                            ['free_word' => $data['occupation_category_free_word'][$i]]
                        );
                    } elseif (!empty($data['occupation_category_free_word'][$i])) {
                        $profile->occupation_categories()->attach(
                            OccupationCategory::ID_OTHERS,
                            ['free_word' => $data['occupation_category_free_word'][$i]]
                        );
                    }
                }

                unset($data['occupation_category']);
                unset($data['occupation_category_free_word']);
            }

            if ($data) {
                $profile->fill($data);
            }
            $ret2 = $profile->save();

            if ($ret1 && $ret2) {
                return true;
            }

            return false;
        });

        return $ret;
    }

    /**
     * Customerのレコードを新規作成し、会員登録メールを送信する
     *
     * @param $req
     * @return Customer|false
     */
    public static function createAndSendMail($req)
    {
        $customer = new self();
        $customer->email = $req->email;
        $customer->phone = $req->phone;

        $save_customer = DB::transaction(function () use ($customer, $req) {
            $carbon = Carbon::create($req->year, $req->month, $req->day);

            $ret1 = $customer->saveWithProfile([
                'username' => $req->username,
                'sex' => $req->sex,
                'birthday' => $carbon,
                'prefecture' => $req->prefecture,
                'school_record_id' => $req->school_record_id,
                'school_name' => $req->school_name,
                'graduate_year' => $req->graduate_year,
                'job_record' => $req->job_record,
                'company_name' => $req->company_name,
                'work_location' => $req->work_location,
                'industry_types' => $req->industry_types,
                'occupation_category' => $req->occupation_category,
                'occupation_category_free_word' => $req->occupation_category_free_word,
            ]);

            if ($ret1) {
                return $customer;
            }

            return false;
        });

        // saveに失敗した場合
        if (!$save_customer) {
            return false;
        }

        $customerConfirm = new CustomerConfirmation();
        $customerConfirm->customer_id = $save_customer->id;
        $customerConfirm->saveWithOnetimeUrl();

        // @mail 仮登録完了メール to Customer
        $limit_date = Carbon::now()->addHours(24);
        $data = [
            'confirmation_url' => url('/register/confirm/' . $customerConfirm->confirmation_token),
            'month' => $limit_date->month,
            'day' => $limit_date->day,
            'hour' => $limit_date->hour,
            'minute' => $limit_date->minute,
        ];

        \Mail::queue(['text' => 'emails.customer.pre_register_customer'], $data, function ($message) use ($save_customer) {
            $message->from('info@education-career.jp')
                ->to($save_customer->email)
                ->subject('【Education Career】会員登録のご案内');
        });

        return $save_customer;
    }
}
