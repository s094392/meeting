<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CSSSO Callback Settings
    |--------------------------------------------------------------------------
    |
    | When an authoization event was triggered, consider this flow:
    | 1. User click on the link that lead to /cssso/redirect(provide by this package).
    | 2. User then be redirected to SSO server and be asked for permission.
    | 3. Authoirzation request done, server redirect to /cssso/callback(provide by this package)
    | with authorization code.
    | 4. /cssso/callback issue a token request to SSO server with authorization code.
    | 5. /cssso/callback get token from server then visit SSO server /api/me with token
    | 6. /cssso/callback get user information from server and stored it into session('user')
    | (token and refresh_token are included)
    | 7. /cssso/callback redirect to this user-customized route
    | And thus you can do further processing with user information stored in the session in
    | the route handler.
    |
    | 當一次授權事件發生時，流程為:
    | 1. 使用者點擊 /cssso/redirect(由此套件提供的路由) 連結
    | 2. 使用者被重導向到 SSO server 端做驗證
    | 3. 驗證完畢， server 端帶著 authorization code 重導向回 /cssso/callback(由此套件提供的路由)
    | 4. /cssso/callback 再次帶著 authorization code 發送 token request 到 SSO server
    | 5. /cssso/callback 取得 token，並帶著 token 拜訪 SSO server /api/me
    | 6. /cssso/callback 取得使用者資料，並存進 session('user') 裡(包含 token 跟 refresh_token)
    | 7. /cssso/callback 重導向到這個使用者自行定義的路由
    | 因此可以自行在這個路由的 handler 裏取得儲存在 session 裡的使用者資訊並做進一步利用
    */

    'handler_route' => '/cssso/handle',
];
