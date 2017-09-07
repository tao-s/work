<?php

use App\Admin;
use App\Client;
use App\ClientRep;
use App\JobCategory;
use App\EmploymentStatus;
use App\BusinessType;
use App\GrandBusinessType;
use App\SchoolRecord;
use App\Tag;
use App\Plan;
use App\ApplicationStatus;
use App\Customer;
use App\CustomerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('AdminTableSeeder');
        $this->call('ClientTableSeeder');
        $this->call('ClientRepTableSeeder');
        $this->call('JobCategoryTableSeeder');
        $this->call('EmploymentStatusTableSeeder');
        $this->call('GrandBusinessTypeTableSeeder');
        $this->call('BusinessTypeTableSeeder');
        $this->call('SchoolRecordTableSeeder');
        $this->call('TagTableSeeder');
        $this->call('PlanTableSeeder');
        $this->call('ApplicationStatusTableSeeder');
        $this->call('CustomerTableSeeder');
        $this->call('CustomerProfileTableSeeder');
        $this->call('IndustryTypesTableSeeder');
        $this->call('OccupationCategoriesTableSeeder');
        $this->call('WorkLocationsTableSeeder');
        $this->call('AreaTableSeeder');
        $this->call('PrefectureTableSeeder');
    }

}

class AdminTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        Admin::create([
            'email' => 'root@education-career.jp',
            'password' => bcrypt('root')
        ]);
    }

}

class ClientTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->delete();
        Client::create([
            'id' => 1,
            'company_name' => 'Education Career',
            'company_id' => 'education_career',
            'can_publish' => 1,
            'url' => 'http://education-career.jp',
        ]);
    }

}

class ClientRepTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('client_reps')->delete();
        ClientRep::create([
            'id' => 1,
            'email' => 'root@education-career.jp',
            'password' => bcrypt('root'),
            'client_id' => 1
        ]);

    }

}

class JobCategoryTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        DB::table('job_categories')->delete();
        $categories = [
            ['title' => '営業職', 'slug' => 'sales-person', 'description' => '法人営業、個人営業、キャリアアドバイザーなど'],
            ['title' => '企画・管理系職', 'slug' => 'planner', 'description' => 'マーケティング、企画、広告宣伝、経理、財務、総務、人事、法務、広報、経営企画、事業統括、事業開発、その他'],
            ['title' => 'エンジニア・技術関連職', 'slug' => 'engineer', 'description' => 'Webエンジニア、アプリエンジニア（iOS、Android等）、プログラマー、通信・インフラエンジニア、ITコンサルタント・システムコンサルタント、システムエンジニア、その他'],
            ['title' => 'クリエイティブ・クリエイター系職種', 'slug' => 'designer', 'description' => 'Webプロデューサー・ディレクター・プランナー、アートディレクター、Webデザイナー・デザイナー、編集／ライター、その他'],
            ['title' => '講師・教員関連職種', 'slug' => 'educator', 'description' => '大学講師、小・中・高等学校教員、保育士・幼稚園教諭、研修講師、スクール長 ／教室長／マネージャー、インストラクター、その他'],
            ['title' => '専門職種（コンサルタント・士業系等）', 'slug' => 'consultant', 'description' => '戦略・経営コンサルタント、組織・人事コンサルタント、業務コンサルタント、その他専門コンサルタント、士業（弁護士・会計士・税理士・弁理士等）'],
            ['title' => '事務系職種', 'slug' => 'clerk', 'description' => '一般事務、経理事務、営業事務、その他アシスタント'],
            ['title' => 'その他', 'slug' => 'job-category-other', 'description' => ''],
        ];

        foreach ($categories as $key => $val) {
            JobCategory::create(['id' => $key + 1, 'title' => $val['title'], 'slug' => $val['slug'], 'description' => $val['description']]);
        }

    }

}

class EmploymentStatusTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        DB::table('employment_statuses')->delete();
        $statuses = [
            ['title' => 'フルタイム（正社員・契約社員)', 'slug' => 'full-time'],
            ['title' => 'パート・アルバイト・インターン', 'slug' => 'part-time'],
            ['title' => '業務委託', 'slug' => 'contract'],
            ['title' => 'プロボノ・ボランティア', 'slug' => 'volunteer'],
            ['title' => 'フランチャイズオーナー', 'slug' => 'franchise'],
            ['title' => 'その他', 'slug' => 'employment-status-other'],
        ];

        foreach ($statuses as $key => $val) {
            EmploymentStatus::create(['id' => $key + 1, 'title' => $val['title'], 'slug' => $val['slug']]);
        }
    }

}

class GrandBusinessTypeTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        DB::table('grand_business_types')->delete();
        $types = [
            ['title' => '学校', 'slug' => 'school'],
            ['title' => '語学学校・サービス', 'slug' => 'language-school'],
            ['title' => '各種スクール', 'slug' => 'other-school'],
            ['title' => '予備校・塾', 'slug' => 'prep-cram-school'],
            ['title' => '教育関連企業', 'slug' => 'edtech-company'],
        ];
        foreach ($types as $key => $val) {
            $value = ['id' => $key + 1, 'title' => $val['title'], 'slug' => $val['slug']];
            GrandBusinessType::create($value);
        }
    }

}

class BusinessTypeTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        DB::table('business_types')->delete();
        $types = [
            ['title' => '大学・大学院', 'slug' => 'university', 'grand_business_type_id' => 1],
            ['title' => '高等学校', 'slug' => 'high-school', 'grand_business_type_id' => 1],
            ['title' => '専門学校・短期大学・高専', 'slug' => 'college', 'grand_business_type_id' => 1],
            ['title' => '中学校', 'slug' => 'middle-school', 'grand_business_type_id' => 1],
            ['title' => '小学校', 'slug' => 'elementary-school', 'grand_business_type_id' => 1],
            ['title' => '保育園・幼稚園・学童保育', 'slug' => 'kinder-garden', 'grand_business_type_id' => 1],
            ['title' => 'フリースクール', 'slug' => 'free-school', 'grand_business_type_id' => 1],
            ['title' => 'その他', 'slug' => 'other', 'grand_business_type_id' => 1],

            ['title' => '英会話スクール・英語塾', 'slug' => 'english-school', 'grand_business_type_id' => 2],
            ['title' => '中国語・韓国語教室', 'slug' => 'chinese-school', 'grand_business_type_id' => 2],
            ['title' => 'ドイツ・フランス・スペイン教室', 'slug' => 'german-school', 'grand_business_type_id' => 2],
            ['title' => '日本語教室', 'slug' => 'japanese-school', 'grand_business_type_id' => 2],
            ['title' => 'その他語学教室', 'slug' => 'other-language-school', 'grand_business_type_id' => 2],

            ['title' => 'プログラミング・パソコンスクール', 'slug' => 'programming-school', 'grand_business_type_id' => 3],
            ['title' => 'デザインスクール', 'slug' => 'design-school', 'grand_business_type_id' => 3],
            ['title' => '料理教室、音楽教室、水泳教室', 'slug' => 'cooking-school', 'grand_business_type_id' => 3],
            ['title' => 'フィットネス・ヨガ・ダンス・スポーツ教室', 'slug' => 'yoga-school', 'grand_business_type_id' => 3],
            ['title' => '資格スクール・予備校', 'slug' => 'certificate-school', 'grand_business_type_id' => 3],

            ['title' => '予備校', 'slug' => 'prep-school', 'grand_business_type_id' => 4],
            ['title' => '学習塾', 'slug' => 'aux-school', 'grand_business_type_id' => 4],
            ['title' => '幼児教室', 'slug' => 'kids-school', 'grand_business_type_id' => 4],

            ['title' => '出版・コンテンツ制作会社', 'slug' => 'publishing', 'grand_business_type_id' => 5],
            ['title' => 'Webサービス・アプリ開発／運営', 'slug' => 'web', 'grand_business_type_id' => 5],
            ['title' => '留学斡旋・サポート', 'slug' => 'ryugaku-support', 'grand_business_type_id' => 5],
            ['title' => '学校・スクール・教室運営', 'slug' => 'schooling', 'grand_business_type_id' => 5],
        ];
        foreach ($types as $key => $val) {
            BusinessType::create(['id' => $key + 1, 'title' => $val['title'], 'slug' => $val['slug'], 'grand_business_type_id' => $val['grand_business_type_id']]);
        }
    }

}

class SchoolRecordTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_records')->delete();
        $records = ['大学院卒（博士）', '大学院卒（修士）', '大学卒', '短大卒', '高専卒', '専門学校卒', '高校卒', '在学中', 'その他'];
        foreach ($records as $key => $val) {
            SchoolRecord::create(['id' => $key + 1, 'title' => $val]);
        }
    }

}

class TagTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->delete();
        $tags = ['未経験者歓迎',
                '在宅・リモートワークOK',
                '子育て経験歓迎',
                '大学生歓迎',
                'ベンチャー・スタートアップ',
                '上場企業',
                'ストックオプション制度あり',
                '教員免許取得者歓迎',
                '新卒歓迎',
                '第２新卒歓迎',
                '語学',
                'プログラミング',
                '知育',
                '大学受験',
                '高校受験',
                '中学受験',
                '社会人向け',
        ];
        foreach ($tags as $key => $val) {
            Tag::create(['id' => $key + 1, 'name' => $val]);
        }

    }

}


class PlanTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->delete();
        Plan::create(['id' => 1, 'plan_name' => '2016年1月末まで無料プラン', 'plan_months' => null]);
        Plan::create(['id' => 2, 'plan_name' => '6ヶ月プラン', 'plan_months' => 6]);
        Plan::create(['id' => 3, 'plan_name' => '1年間プラン', 'plan_months' => 12]);
    }

}

class ApplicationStatusTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('application_statuses')->delete();
        $statuses = ['未選考',
                    '保留',
                    '連絡済み',
                    '不採用',
                    '採用済み'
        ];
        foreach ($statuses as $key => $val) {
            ApplicationStatus::create(['id' => $key + 1, 'label' => $val]);
        }
    }

}


class CustomerTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->delete();
        Customer::create([
            'id' => 1,
            'email' => 'keita.dev@gmail.com',
            'password' => '$2y$10$7jmp06jVYHOVuNBTpfZpjech9E4OQlKpNBlsTFT/sKsuKwXTf0UqC',
            'is_activated' => 1,
            'remember_token' => null,
            'created_at' => '2015-09-03 16:22:31',
            'updated_at' => '2015-09-21 11:05:58',
            'deleted_at' => null
        ]);
    }

}


class CustomerProfileTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer_profiles')->delete();
        CustomerProfile::create([
            'id' => 1,
            'customer_id' => 1,
            'username' => 'yamada',
            'sex' => 1,
            'birthday' => '1986-10-30',
            'introduction' => null,
            'future_plan' => null,
            'job_record' => null,
            'skill' => null,
            'qualification' => null,
            'created_at' => '2015-09-03 16:22:31',
            'updated_at' => '2015-09-03 16:22:31'
        ]);
    }

}

class IndustryTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('industry_types')->delete();

        $data = [
            1 => '学習塾／予備校／専門学校／学校法人',
            2 => 'その他・各種スクール',
            3 => '通信・インターネット',
            4 => '広告／メディア',
            5 => 'コンサルティング／リサーチ／専門事務所',
            6 => '人材サービス／アウトソーシング／コールセンター',
            7 => 'メーカー',
            8 => '商社',
            9 => '医療',
            10 => '金融',
            11 => '小売',
            12 => '外食',
            13 => '旅行／宿泊／レジャー',
            14 => 'その他',
        ];

        foreach ($data as $id => $name) {
            \App\IndustryType::create(['id' => $id, 'name' => $name]);
        }
    }
}

class OccupationCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('occupation_categories')->delete();

        $data = [
            10 => '法人営業',
            11 => '個人営業',
            20 => 'マーケティング／企画／広告宣伝',
            21 => '経理／財務／税務／会計',
            22 => '総務／人事／法務／知財／広報・IR／内部監査',
            23 => '経営／経営企画／事業統括／事業開発',
            24 => 'その他',
            30 => 'アプリケーションエンジニア/システム開発',
            31 => '通信・インフラエンジニア',
            32 => 'ITコンサルタント・システムコンサルタント',
            33 => 'システムエンジニア',
            34 => 'プリセールス',
            35 => 'その他',
            40 => 'Webプロデューサー・ディレクター・プランナー/システム開発',
            41 => 'アートディレクター',
            42 => 'Webデザイナー・デザイナー',
            43 => 'アプリエンジニア（iOS、Android等）',
            44 => 'プログラマー／Webエンジニア',
            45 => 'Webコーダー',
            46 => '編集／ライター',
            47 => 'その他',
            50 => '大学講師',
            51 => '小・中・高等学校教員',
            52 => '保育士・幼稚園教諭',
            53 => '研修講師',
            54 => 'スクール長／教室長／マネージャー',
            55 => 'インストラクター',
            56 => 'その他',
            60 => '戦略・経営コンサルタント',
            61 => '組織・人事コンサルタント',
            62 => '業務コンサルタント',
            63 => 'その他専門コンサルタント',
            64 => '士業（弁護士・会計士・税理士・弁理士等）',
            70 => '一般事務',
            71 => '経理事務',
            72 => '営業事務',
            73 => 'その他アシスタント事務職',
            80 => 'その他',
        ];

        foreach ($data as $id => $name) {
            \App\OccupationCategory::create(['id' => $id, 'name' => $name]);
        }
    }
}

class WorkLocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_locations')->delete();

        $data = Config::get('prefecture');
        $data['48'] = '海外';

        foreach ($data as $id => $name) {
            \App\WorkLocation::create(['id' => $id, 'name' => $name]);
        }
    }
}

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        DB::table('areas')->delete();
        $data = [
            ['title' => '北海道・東北', 'slug' => 'tohoku'],
            ['title' => '北関東', 'slug' => 'kita-kanto'],
            ['title' => '首都圏', 'slug' => 'syutoken'],
            ['title' => '北陸・甲信越', 'slug' => 'hokuriku'],
            ['title' => '東海', 'slug' => 'tokai'],
            ['title' => '関西', 'slug' => 'kansai'],
            ['title' => '中国・四国', 'slug' => 'chugoku'],
            ['title' => '九州・沖縄', 'slug' => 'kyushu'],
        ];

        foreach ($data as $key => $val) {
            \App\Area::create(['id' => $key+1, 'title' => $val['title'], 'slug' => $val['slug']]);
        }
    }
}


class PrefectureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        DB::table('prefectures')->delete();

        $data = [
            ['id' => 1,'sort' => 1, 'casual_title' => "東京", 'formal_title' => "東京都", 'slug' => 'tokyo', 'area_id' => 3],
            ['id' => 2,'sort' => 2, 'casual_title' => "北海道", 'formal_title' => "北海道", 'slug' => 'hokkaido', 'area_id' => 1],
            ['id' => 3,'sort' => 3, 'casual_title' => "青森", 'formal_title' => "青森県", 'slug' => 'aomori', 'area_id' => 1],
            ['id' => 6,'sort' => 4, 'casual_title' => "秋田", 'formal_title' => "秋田県", 'slug' => 'akita', 'area_id' => 1],
            ['id' => 4,'sort' => 5, 'casual_title' => "岩手", 'formal_title' => "岩手県", 'slug' => 'iwate', 'area_id' => 1],
            ['id' => 7,'sort' => 6, 'casual_title' => "山形", 'formal_title' => "山形県", 'slug' => 'yamagata', 'area_id' => 1],
            ['id' => 5,'sort' => 7, 'casual_title' => "宮城", 'formal_title' => "宮城県", 'slug' => 'miyagi', 'area_id' => 1],
            ['id' => 8,'sort' => 8, 'casual_title' => "福島", 'formal_title' => "福島県", 'slug' => 'fukushima', 'area_id' => 1],
            ['id' => 9,'sort' => 9, 'casual_title' => "茨城", 'formal_title' => "茨城県", 'slug' => 'ibaraki', 'area_id' => 2],
            ['id' => 10,'sort' => 10, 'casual_title' => "栃木", 'formal_title' => "栃木県", 'slug' => 'tochigi', 'area_id' => 2],
            ['id' => 11,'sort' => 11, 'casual_title' => "群馬", 'formal_title' => "群馬県", 'slug' => 'gunma', 'area_id' => 2],
            ['id' => 14,'sort' => 12, 'casual_title' => "神奈川",'formal_title' => "神奈川県", 'slug' => 'kanagawa', 'area_id' => 3],
            ['id' => 12,'sort' => 13, 'casual_title' => "埼玉", 'formal_title' => "埼玉県", 'slug' => 'saitama', 'area_id' => 3],
            ['id' => 13,'sort' => 14, 'casual_title' => "千葉", 'formal_title' => "千葉県", 'slug' => 'chiba', 'area_id' => 3],
            ['id' => 16,'sort' => 15, 'casual_title' => "富山", 'formal_title' => "富山県", 'slug' => 'toyama', 'area_id' => 4],
            ['id' => 17,'sort' => 16, 'casual_title' => "石川", 'formal_title' => "石川県", 'slug' => 'ishikawa', 'area_id' => 4],
            ['id' => 18,'sort' => 17, 'casual_title' => "福井", 'formal_title' => "福井県", 'slug' => 'fukui', 'area_id' => 4],
            ['id' => 15,'sort' => 18, 'casual_title' => "新潟", 'formal_title' => "新潟県", 'slug' => 'niigata', 'area_id' => 4],
            ['id' => 19,'sort' => 19, 'casual_title' => "山梨", 'formal_title' => "山梨県", 'slug' => 'yamanashi', 'area_id' => 4],
            ['id' => 20,'sort' => 20, 'casual_title' => "長野", 'formal_title' => "長野県", 'slug' => 'nagano', 'area_id' => 4],
            ['id' => 23,'sort' => 21, 'casual_title' => "愛知", 'formal_title' => "愛知県", 'slug' => 'aichi', 'area_id' => 5],
            ['id' => 22,'sort' => 22, 'casual_title' => "静岡", 'formal_title' => "静岡県", 'slug' => 'shizuoka', 'area_id' => 5],
            ['id' => 24,'sort' => 23, 'casual_title' => "三重", 'formal_title' => "三重県", 'slug' => 'mie', 'area_id' => 5],
            ['id' => 21,'sort' => 25, 'casual_title' => "岐阜", 'formal_title' => "岐阜県", 'slug' => 'gifu', 'area_id' => 5],
            ['id' => 27,'sort' => 26, 'casual_title' => "大阪", 'formal_title' => "大阪府", 'slug' => 'osaka', 'area_id' => 6],
            ['id' => 26,'sort' => 26, 'casual_title' => "京都", 'formal_title' => "京都府", 'slug' => 'kyoto', 'area_id' => 6],
            ['id' => 28,'sort' => 27, 'casual_title' => "兵庫", 'formal_title' => "兵庫県", 'slug' => 'hyogo', 'area_id' => 6],
            ['id' => 25,'sort' => 28, 'casual_title' => "滋賀", 'formal_title' => "滋賀県", 'slug' => 'shiga', 'area_id' => 6],
            ['id' => 29,'sort' => 29, 'casual_title' => "奈良", 'formal_title' => "奈良県", 'slug' => 'nara', 'area_id' => 6],
            ['id' => 30,'sort' => 30, 'casual_title' => "和歌山",'formal_title' => "和歌山県", 'slug' => 'wakayama', 'area_id' => 6],
            ['id' => 34,'sort' => 31, 'casual_title' => "広島", 'formal_title' => "広島県", 'slug' => 'hiroshima', 'area_id' => 7],
            ['id' => 33,'sort' => 32, 'casual_title' => "岡山", 'formal_title' => "岡山県", 'slug' => 'okayama', 'area_id' => 7],
            ['id' => 35,'sort' => 33, 'casual_title' => "山口", 'formal_title' => "山口県", 'slug' => 'yamaguchi', 'area_id' => 7],
            ['id' => 31,'sort' => 34, 'casual_title' => "鳥取", 'formal_title' => "鳥取県", 'slug' => 'tottori', 'area_id' => 7],
            ['id' => 32,'sort' => 35, 'casual_title' => "島根", 'formal_title' => "島根県", 'slug' => 'shimane', 'area_id' => 7],
            ['id' => 36,'sort' => 37, 'casual_title' => "徳島", 'formal_title' => "徳島県", 'slug' => 'tokushima', 'area_id' => 7],
            ['id' => 37,'sort' => 37, 'casual_title' => "香川", 'formal_title' => "香川県", 'slug' => 'kagawa', 'area_id' => 7],
            ['id' => 38,'sort' => 38, 'casual_title' => "愛媛", 'formal_title' => "愛媛県", 'slug' => 'ehime', 'area_id' => 7],
            ['id' => 39,'sort' => 39, 'casual_title' => "高知", 'formal_title' => "高知県", 'slug' => 'kouchi', 'area_id' => 7],
            ['id' => 40,'sort' => 40, 'casual_title' => "福岡", 'formal_title' => "福岡県", 'slug' => 'fukuoka', 'area_id' => 8],
            ['id' => 41,'sort' => 41, 'casual_title' => "佐賀", 'formal_title' => "佐賀県", 'slug' => 'saga', 'area_id' => 8],
            ['id' => 43,'sort' => 42, 'casual_title' => "熊本", 'formal_title' => "熊本県", 'slug' => 'kumamoto', 'area_id' => 8],
            ['id' => 44,'sort' => 43, 'casual_title' => "大分", 'formal_title' => "大分県", 'slug' => 'oita', 'area_id' => 8],
            ['id' => 42,'sort' => 44, 'casual_title' => "長崎", 'formal_title' => "長崎県", 'slug' => 'nagasaki', 'area_id' => 8],
            ['id' => 45,'sort' => 45, 'casual_title' => "宮崎", 'formal_title' => "宮崎県", 'slug' => 'miyazaki', 'area_id' => 8],
            ['id' => 46,'sort' => 46, 'casual_title' => "鹿児島",'formal_title' => "鹿児島県", 'slug' => 'kagoshima', 'area_id' => 8],
            ['id' => 47,'sort' => 47, 'casual_title' => "沖縄", 'formal_title' => "沖縄県",  'slug' => 'okinawa', 'area_id' => 8],
        ];


        foreach ($data as $key => $val) {
            \App\Prefecture::create([
                'id' => $val['id'],
                'formal_title' => $val['formal_title'],
                'casual_title' => $val['casual_title'],
                'sort' => $val['sort'],
                'slug' => $val['slug'],
                'area_id' => $val['area_id'],
            ]);
        }
    }
}