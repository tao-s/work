<div class="modal fade" id="modalToPlan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Education Career</h4>
            </div>
            <div class="modal-body">
                以下の場合には有料プランへのアップグレードが必要になります：<br><br>
                <ul>
                    <li>求人を2つ以上投稿する場合</li>
                    <li>求人を2つ以上公開する場合</li>
                    <li>応募を10件以上閲覧する場合</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                <a class="btn btn-success" role="button" href="{{ url('/upgrade') }}">有料プランにアップグレードする</a>
            </div>
        </div>
    </div>
</div>