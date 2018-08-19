<template>
<div>
    <h2>所有會議</h2>
    <div class="uk-card uk-card-default uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-divider meetings-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>會議分類</th>
                    <th>會議名稱</th>
                    <th>開始時間</th>
                    <th>結束時間</th>
                    <th>發起人</th>
                    <th>會議狀態</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>100</td>
                    <td >NET</td>
                    <td >Meeting 暨 新生報告</td>
                    <td >2018-08-16 19:36</td>
                    <td>2018-08-17 13:22</td>
                    <td >0000000000</td>
                    <td >會議結束</td>
                </tr>
                <tr>
                    <td>100</td>
                    <td>Net</td>
                    <td>Meeting 暨 新生報告</td>
                    <td>2018-08-16 19:36</td>
                    <td>2018-08-17 13:22</td>
                    <td>0000000000</td>
                    <td>會議結束</td>
                </tr>
                <tr>
                    <td>100</td>
                    <td>NET</td>
                    <td>Meeting 暨 新生報告</td>

                    <td>2018-08-16 19:36</td>
                    <td>2018-08-17 13:22</td>
                    <td>0000000000</td>
                    <td>會議結束</td>
                </tr>
            </tbody>
        </table>
    </div>
    <ul class="uk-pagination uk-flex-center" uk-margin>
    <li><a href="#"><span uk-pagination-previous></span></a></li>
    <li><a href="#">1</a></li>
    <li class="uk-disabled"><span>...</span></li>
    <li><a href="#">5</a></li>
    <li><a href="#">6</a></li>
    <li class="uk-active"><span>7</span></li>
    <li><a href="#">8</a></li>
    <li><a href="#"><span uk-pagination-next></span></a></li>
</ul>
</div>
</template>

<script>
export default {};
</script>
