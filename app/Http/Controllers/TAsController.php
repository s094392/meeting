<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;

class TAsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $server_url = env("CSSSO_SERVER", null);
        // $http = new GuzzleHttp\Client();
        // $response = $http->get($server_url.'/api/tas');
        // return json_decode((string) $response->getBody(), true);

        return '{
            "phdta": [
                {
                    "uid": "ycchang",
                    "uidNumber": 1
                },
                {
                    "uid": "wangth",
                    "uidNumber": 2
                },
                {
                    "uid": "tzuyu",
                    "uidNumber": 3
                },
                {
                    "uid": "linpc",
                    "uidNumber": 4
                }
            ],
            "netta": [
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "tzuyu",
                    "uidNumber": 3
                },
                {
                    "uid": "yaowen",
                    "uidNumber": 6
                },
                {
                    "uid": "calee",
                    "uidNumber": 7
                },
                {
                    "uid": "youwei1129",
                    "uidNumber": 8
                },
                {
                    "uid": "syujy",
                    "uidNumber": 9
                },
                {
                    "uid": "wwchung",
                    "uidNumber": 10
                },
                {
                    "uid": "yahsieh",
                    "uidNumber": 11
                }
            ],
            "autota": [
                {
                    "uid": "tsuyi",
                    "uidNumber": 12
                },
                {
                    "uid": "kcchung",
                    "uidNumber": 13
                }
            ],
            "leaderta": [
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "zjlin",
                    "uidNumber": 14
                },
                {
                    "uid": "hwlin1414",
                    "uidNumber": 15
                },
                {
                    "uid": "weicc",
                    "uidNumber": 16
                },
                {
                    "uid": "calee",
                    "uidNumber": 7
                },
                {
                    "uid": "wangtr",
                    "uidNumber": 17
                },
                {
                    "uid": "wwchung",
                    "uidNumber": 10
                },
                {
                    "uid": "blzhuang",
                    "uidNumber": 18
                }
            ],
            "cs-ta": [
                {
                    "uid": "ycchang",
                    "uidNumber": 1
                },
                {
                    "uid": "tzuyu",
                    "uidNumber": 3
                },
                {
                    "uid": "hyili",
                    "uidNumber": 19
                },
                {
                    "uid": "chenshh",
                    "uidNumber": 20
                },
                {
                    "uid": "yanglin",
                    "uidNumber": 21
                },
                {
                    "uid": "cfhsu1993",
                    "uidNumber": 22
                },
                {
                    "uid": "hwlin1414",
                    "uidNumber": 15
                },
                {
                    "uid": "zjlin",
                    "uidNumber": 14
                },
                {
                    "uid": "blzhuang",
                    "uidNumber": 18
                },
                {
                    "uid": "yoychen",
                    "uidNumber": 23
                },
                {
                    "uid": "wlliou",
                    "uidNumber": 24
                },
                {
                    "uid": "weicc",
                    "uidNumber": 16
                },
                {
                    "uid": "yca",
                    "uidNumber": 25
                },
                {
                    "uid": "wangtr",
                    "uidNumber": 17
                },
                {
                    "uid": "calee",
                    "uidNumber": 7
                },
                {
                    "uid": "yaowen",
                    "uidNumber": 6
                },
                {
                    "uid": "fuyu0425",
                    "uidNumber": 26
                },
                {
                    "uid": "hcchuang",
                    "uidNumber": 27
                },
                {
                    "uid": "hcdai",
                    "uidNumber": 28
                },
                {
                    "uid": "yysung",
                    "uidNumber": 29
                },
                {
                    "uid": "hchsu0426",
                    "uidNumber": 30
                },
                {
                    "uid": "linsc04",
                    "uidNumber": 31
                },
                {
                    "uid": "sudj0130",
                    "uidNumber": 32
                },
                {
                    "uid": "youwei1129",
                    "uidNumber": 8
                },
                {
                    "uid": "wwchung",
                    "uidNumber": 10
                },
                {
                    "uid": "wangth",
                    "uidNumber": 2
                },
                {
                    "uid": "zswu",
                    "uidNumber": 33
                },
                {
                    "uid": "yahsieh",
                    "uidNumber": 11
                },
                {
                    "uid": "syujy",
                    "uidNumber": 9
                },
                {
                    "uid": "yenck",
                    "uidNumber": 34
                },
                {
                    "uid": "hchou",
                    "uidNumber": 35
                },
                {
                    "uid": "cscc-automation",
                    "uidNumber": 36
                },
                {
                    "uid": "linpc",
                    "uidNumber": 4
                },
                {
                    "uid": "ysw",
                    "uidNumber": 37
                },
                {
                    "uid": "kuohh",
                    "uidNumber": 38
                },
                {
                    "uid": "ycliang",
                    "uidNumber": 39
                },
                {
                    "uid": "wengyc",
                    "uidNumber": 40
                },
                {
                    "uid": "mllee",
                    "uidNumber": 41
                },
                {
                    "uid": "ykzheng",
                    "uidNumber": 42
                },
                {
                    "uid": "jbliao",
                    "uidNumber": 43
                },
                {
                    "uid": "tzute",
                    "uidNumber": 44
                },
                {
                    "uid": "ctu",
                    "uidNumber": 45
                },
                {
                    "uid": "xhweng",
                    "uidNumber": 46
                },
                {
                    "uid": "chenyee",
                    "uidNumber": 47
                },
                {
                    "uid": "austin",
                    "uidNumber": 48
                },
                {
                    "uid": "tsengcy",
                    "uidNumber": 49
                },
                {
                    "uid": "yuanchen",
                    "uidNumber": 50
                }
            ],
            "vmta": [
                {
                    "uid": "ycchang",
                    "uidNumber": 1
                },
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "wwchung",
                    "uidNumber": 10
                },
                {
                    "uid": "calee",
                    "uidNumber": 7
                },
                {
                    "uid": "hcchuang",
                    "uidNumber": 27
                },
                {
                    "uid": "syujy",
                    "uidNumber": 9
                },
                {
                    "uid": "weicc",
                    "uidNumber": 16
                },
                {
                    "uid": "blzhuang",
                    "uidNumber": 18
                },
                {
                    "uid": "hwlin1414",
                    "uidNumber": 15
                },
                {
                    "uid": "zjlin",
                    "uidNumber": 14
                }
            ],
            "vcsta": [
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "zjlin",
                    "uidNumber": 14
                },
                {
                    "uid": "weicc",
                    "uidNumber": 16
                },
                {
                    "uid": "blzhuang",
                    "uidNumber": 18
                },
                {
                    "uid": "hwlin1414",
                    "uidNumber": 15
                }
            ],
            "colocationta": [
                {
                    "uid": "tsn",
                    "uidNumber": 51
                },
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "taitc",
                    "uidNumber": 52
                },
                {
                    "uid": "chenshh",
                    "uidNumber": 20
                }
            ],
            "printta": [
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "taitc",
                    "uidNumber": 52
                },
                {
                    "uid": "yanglin",
                    "uidNumber": 21
                },
                {
                    "uid": "yoychen",
                    "uidNumber": 23
                },
                {
                    "uid": "blzhuang",
                    "uidNumber": 18
                }
            ],
            "scheduleta": [
                {
                    "uid": "hwlin1414",
                    "uidNumber": 15
                },
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "tzuyu",
                    "uidNumber": 3
                }
            ],
            "bbsta": [
                {
                    "uid": "pychen5538",
                    "uidNumber": 53
                },
                {
                    "uid": "gyzheng",
                    "uidNumber": 54
                },
                {
                    "uid": "yawchen",
                    "uidNumber": 55
                },
                {
                    "uid": "taitc",
                    "uidNumber": 52
                },
                {
                    "uid": "chihhsin",
                    "uidNumber": 56
                },
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "yacwu",
                    "uidNumber": 57
                },
                {
                    "uid": "zylin",
                    "uidNumber": 58
                }
            ],
            "allta": [
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "zjlin",
                    "uidNumber": 14
                },
                {
                    "uid": "hwlin1414",
                    "uidNumber": 15
                }
            ],
            "msdnta": [
                {
                    "uid": "taitc",
                    "uidNumber": 52
                },
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                }
            ],
            "ldapta": [
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "cfhsu1993",
                    "uidNumber": 22
                },
                {
                    "uid": "weicc",
                    "uidNumber": 16
                },
                {
                    "uid": "zjlin",
                    "uidNumber": 14
                }
            ],
            "pcta": [
                {
                    "uid": "hyili",
                    "uidNumber": 19
                },
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "yacwu",
                    "uidNumber": 57
                },
                {
                    "uid": "chenshh",
                    "uidNumber": 20
                },
                {
                    "uid": "yanglin",
                    "uidNumber": 21
                },
                {
                    "uid": "wangtr",
                    "uidNumber": 17
                },
                {
                    "uid": "linsc04",
                    "uidNumber": 31
                },
                {
                    "uid": "yaowen",
                    "uidNumber": 6
                },
                {
                    "uid": "hchsu0426",
                    "uidNumber": 30
                },
                {
                    "uid": "yca",
                    "uidNumber": 25
                },
                {
                    "uid": "fuyu0425",
                    "uidNumber": 26
                },
                {
                    "uid": "calee",
                    "uidNumber": 7
                },
                {
                    "uid": "hcchuang",
                    "uidNumber": 27
                },
                {
                    "uid": "hcdai",
                    "uidNumber": 28
                },
                {
                    "uid": "yysung",
                    "uidNumber": 29
                },
                {
                    "uid": "youwei1129",
                    "uidNumber": 8
                },
                {
                    "uid": "zswu",
                    "uidNumber": 33
                },
                {
                    "uid": "yahsieh",
                    "uidNumber": 11
                },
                {
                    "uid": "syujy",
                    "uidNumber": 9
                },
                {
                    "uid": "yenck",
                    "uidNumber": 34
                },
                {
                    "uid": "hchou",
                    "uidNumber": 35
                }
            ],
            "wwwta": [
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "hyili",
                    "uidNumber": 19
                },
                {
                    "uid": "yanglin",
                    "uidNumber": 21
                },
                {
                    "uid": "cfhsu1993",
                    "uidNumber": 22
                },
                {
                    "uid": "fuyu0425",
                    "uidNumber": 26
                },
                {
                    "uid": "yoychen",
                    "uidNumber": 23
                },
                {
                    "uid": "wlliou",
                    "uidNumber": 24
                },
                {
                    "uid": "linsc04",
                    "uidNumber": 31
                },
                {
                    "uid": "hcdai",
                    "uidNumber": 28
                },
                {
                    "uid": "yysung",
                    "uidNumber": 29
                },
                {
                    "uid": "zswu",
                    "uidNumber": 33
                },
                {
                    "uid": "blzhuang",
                    "uidNumber": 18
                },
                {
                    "uid": "hchou",
                    "uidNumber": 35
                },
                {
                    "uid": "yushuen",
                    "uidNumber": 59
                }
            ],
            "doorta": [
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "tzuyu",
                    "uidNumber": 3
                },
                {
                    "uid": "youwei1129",
                    "uidNumber": 8
                },
                {
                    "uid": "wwchung",
                    "uidNumber": 10
                },
                {
                    "uid": "wlliou",
                    "uidNumber": 24
                }
            ],
            "newsta": [
                {
                    "uid": "lctseng",
                    "uidNumber": 60
                },
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "kshuang",
                    "uidNumber": 61
                }
            ],
            "mailta": [
                {
                    "uid": "hyili",
                    "uidNumber": 19
                },
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "yca",
                    "uidNumber": 25
                },
                {
                    "uid": "wangtr",
                    "uidNumber": 17
                },
                {
                    "uid": "hchsu0426",
                    "uidNumber": 30
                },
                {
                    "uid": "weicc",
                    "uidNumber": 16
                },
                {
                    "uid": "hwlin1414",
                    "uidNumber": 15
                },
                {
                    "uid": "wwchung",
                    "uidNumber": 10
                },
                {
                    "uid": "tzute",
                    "uidNumber": 44
                },
                {
                    "uid": "hchou",
                    "uidNumber": 35
                }
            ],
            "linuxta": [
                {
                    "uid": "chenshh",
                    "uidNumber": 20
                },
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "yanglin",
                    "uidNumber": 21
                },
                {
                    "uid": "cfhsu1993",
                    "uidNumber": 22
                },
                {
                    "uid": "yoychen",
                    "uidNumber": 23
                },
                {
                    "uid": "weicc",
                    "uidNumber": 16
                },
                {
                    "uid": "calee",
                    "uidNumber": 7
                },
                {
                    "uid": "hcchuang",
                    "uidNumber": 27
                },
                {
                    "uid": "hcdai",
                    "uidNumber": 28
                },
                {
                    "uid": "yysung",
                    "uidNumber": 29
                },
                {
                    "uid": "zswu",
                    "uidNumber": 33
                },
                {
                    "uid": "yahsieh",
                    "uidNumber": 11
                },
                {
                    "uid": "blzhuang",
                    "uidNumber": 18
                },
                {
                    "uid": "hchou",
                    "uidNumber": 35
                },
                {
                    "uid": "ycliang",
                    "uidNumber": 39
                },
                {
                    "uid": "mllee",
                    "uidNumber": 41
                },
                {
                    "uid": "austin",
                    "uidNumber": 48
                },
                {
                    "uid": "ctu",
                    "uidNumber": 45
                }
            ],
            "bsdta": [
                {
                    "uid": "phdta-only",
                    "uidNumber": 5
                },
                {
                    "uid": "yacwu",
                    "uidNumber": 57
                },
                {
                    "uid": "hyili",
                    "uidNumber": 19
                },
                {
                    "uid": "zjlin",
                    "uidNumber": 14
                },
                {
                    "uid": "hwlin1414",
                    "uidNumber": 15
                },
                {
                    "uid": "wlliou",
                    "uidNumber": 24
                },
                {
                    "uid": "wwchung",
                    "uidNumber": 10
                },
                {
                    "uid": "wangtr",
                    "uidNumber": 17
                },
                {
                    "uid": "linsc04",
                    "uidNumber": 31
                },
                {
                    "uid": "yaowen",
                    "uidNumber": 6
                },
                {
                    "uid": "hchsu0426",
                    "uidNumber": 30
                },
                {
                    "uid": "yca",
                    "uidNumber": 25
                },
                {
                    "uid": "fuyu0425",
                    "uidNumber": 26
                },
                {
                    "uid": "syujy",
                    "uidNumber": 9
                },
                {
                    "uid": "yenck",
                    "uidNumber": 34
                },
                {
                    "uid": "tzute",
                    "uidNumber": 44
                },
                {
                    "uid": "jbliao",
                    "uidNumber": 43
                },
                {
                    "uid": "youwei1129",
                    "uidNumber": 8
                }
            ],
            "testta": [
                {
                    "uid": "zjlin",
                    "uidNumber": 14
                }
            ]
        }
        ';
    }
}
