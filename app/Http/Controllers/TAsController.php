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
    public function grouped()
    {
        // $server_url = env("CSSSO_SERVER", null);
        // $http = new GuzzleHttp\Client();
        // $response = $http->get($server_url.'/api/tas');
        // return json_decode((string) $response->getBody(), true);

        return json_decode('{
            "phdta": [
                {
                    "username": "ycchang",
                    "user_id": 1
                },
                {
                    "username": "wangth",
                    "user_id": 2
                },
                {
                    "username": "tzuyu",
                    "user_id": 3
                },
                {
                    "username": "linpc",
                    "user_id": 4
                }
            ],
            "netta": [
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "tzuyu",
                    "user_id": 3
                },
                {
                    "username": "yaowen",
                    "user_id": 6
                },
                {
                    "username": "calee",
                    "user_id": 7
                },
                {
                    "username": "youwei1129",
                    "user_id": 8
                },
                {
                    "username": "syujy",
                    "user_id": 9
                },
                {
                    "username": "wwchung",
                    "user_id": 10
                },
                {
                    "username": "yahsieh",
                    "user_id": 11
                }
            ],
            "autota": [
                {
                    "username": "tsuyi",
                    "user_id": 12
                },
                {
                    "username": "kcchung",
                    "user_id": 13
                }
            ],
            "leaderta": [
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "zjlin",
                    "user_id": 14
                },
                {
                    "username": "hwlin1414",
                    "user_id": 15
                },
                {
                    "username": "weicc",
                    "user_id": 16
                },
                {
                    "username": "calee",
                    "user_id": 7
                },
                {
                    "username": "wangtr",
                    "user_id": 17
                },
                {
                    "username": "wwchung",
                    "user_id": 10
                },
                {
                    "username": "blzhuang",
                    "user_id": 18
                }
            ],
            "cs-ta": [
                {
                    "username": "ycchang",
                    "user_id": 1
                },
                {
                    "username": "tzuyu",
                    "user_id": 3
                },
                {
                    "username": "hyili",
                    "user_id": 19
                },
                {
                    "username": "chenshh",
                    "user_id": 20
                },
                {
                    "username": "yanglin",
                    "user_id": 21
                },
                {
                    "username": "cfhsu1993",
                    "user_id": 22
                },
                {
                    "username": "hwlin1414",
                    "user_id": 15
                },
                {
                    "username": "zjlin",
                    "user_id": 14
                },
                {
                    "username": "blzhuang",
                    "user_id": 18
                },
                {
                    "username": "yoychen",
                    "user_id": 23
                },
                {
                    "username": "wlliou",
                    "user_id": 24
                },
                {
                    "username": "weicc",
                    "user_id": 16
                },
                {
                    "username": "yca",
                    "user_id": 25
                },
                {
                    "username": "wangtr",
                    "user_id": 17
                },
                {
                    "username": "calee",
                    "user_id": 7
                },
                {
                    "username": "yaowen",
                    "user_id": 6
                },
                {
                    "username": "fuyu0425",
                    "user_id": 26
                },
                {
                    "username": "hcchuang",
                    "user_id": 27
                },
                {
                    "username": "hcdai",
                    "user_id": 28
                },
                {
                    "username": "yysung",
                    "user_id": 29
                },
                {
                    "username": "hchsu0426",
                    "user_id": 30
                },
                {
                    "username": "linsc04",
                    "user_id": 31
                },
                {
                    "username": "sudj0130",
                    "user_id": 32
                },
                {
                    "username": "youwei1129",
                    "user_id": 8
                },
                {
                    "username": "wwchung",
                    "user_id": 10
                },
                {
                    "username": "wangth",
                    "user_id": 2
                },
                {
                    "username": "zswu",
                    "user_id": 33
                },
                {
                    "username": "yahsieh",
                    "user_id": 11
                },
                {
                    "username": "syujy",
                    "user_id": 9
                },
                {
                    "username": "yenck",
                    "user_id": 34
                },
                {
                    "username": "hchou",
                    "user_id": 35
                },
                {
                    "username": "cscc-automation",
                    "user_id": 36
                },
                {
                    "username": "linpc",
                    "user_id": 4
                },
                {
                    "username": "ysw",
                    "user_id": 37
                },
                {
                    "username": "kuohh",
                    "user_id": 38
                },
                {
                    "username": "ycliang",
                    "user_id": 39
                },
                {
                    "username": "wengyc",
                    "user_id": 40
                },
                {
                    "username": "mllee",
                    "user_id": 41
                },
                {
                    "username": "ykzheng",
                    "user_id": 42
                },
                {
                    "username": "jbliao",
                    "user_id": 43
                },
                {
                    "username": "tzute",
                    "user_id": 44
                },
                {
                    "username": "ctu",
                    "user_id": 45
                },
                {
                    "username": "xhweng",
                    "user_id": 46
                },
                {
                    "username": "chenyee",
                    "user_id": 47
                },
                {
                    "username": "austin",
                    "user_id": 48
                },
                {
                    "username": "tsengcy",
                    "user_id": 16913
                },
                {
                    "username": "yuanchen",
                    "user_id": 50
                }
            ],
            "vmta": [
                {
                    "username": "ycchang",
                    "user_id": 1
                },
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "wwchung",
                    "user_id": 10
                },
                {
                    "username": "calee",
                    "user_id": 7
                },
                {
                    "username": "hcchuang",
                    "user_id": 27
                },
                {
                    "username": "syujy",
                    "user_id": 9
                },
                {
                    "username": "weicc",
                    "user_id": 16
                },
                {
                    "username": "blzhuang",
                    "user_id": 18
                },
                {
                    "username": "hwlin1414",
                    "user_id": 15
                },
                {
                    "username": "zjlin",
                    "user_id": 14
                }
            ],
            "vcsta": [
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "zjlin",
                    "user_id": 14
                },
                {
                    "username": "weicc",
                    "user_id": 16
                },
                {
                    "username": "blzhuang",
                    "user_id": 18
                },
                {
                    "username": "hwlin1414",
                    "user_id": 15
                }
            ],
            "colocationta": [
                {
                    "username": "tsn",
                    "user_id": 51
                },
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "taitc",
                    "user_id": 52
                },
                {
                    "username": "chenshh",
                    "user_id": 20
                }
            ],
            "printta": [
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "taitc",
                    "user_id": 52
                },
                {
                    "username": "yanglin",
                    "user_id": 21
                },
                {
                    "username": "yoychen",
                    "user_id": 23
                },
                {
                    "username": "blzhuang",
                    "user_id": 18
                }
            ],
            "scheduleta": [
                {
                    "username": "hwlin1414",
                    "user_id": 15
                },
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "tzuyu",
                    "user_id": 3
                }
            ],
            "bbsta": [
                {
                    "username": "pychen5538",
                    "user_id": 53
                },
                {
                    "username": "gyzheng",
                    "user_id": 54
                },
                {
                    "username": "yawchen",
                    "user_id": 55
                },
                {
                    "username": "taitc",
                    "user_id": 52
                },
                {
                    "username": "chihhsin",
                    "user_id": 56
                },
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "yacwu",
                    "user_id": 57
                },
                {
                    "username": "zylin",
                    "user_id": 58
                }
            ],
            "allta": [
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "zjlin",
                    "user_id": 14
                },
                {
                    "username": "hwlin1414",
                    "user_id": 15
                }
            ],
            "msdnta": [
                {
                    "username": "taitc",
                    "user_id": 52
                },
                {
                    "username": "phdta-only",
                    "user_id": 5
                }
            ],
            "ldapta": [
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "cfhsu1993",
                    "user_id": 22
                },
                {
                    "username": "weicc",
                    "user_id": 16
                },
                {
                    "username": "zjlin",
                    "user_id": 14
                }
            ],
            "pcta": [
                {
                    "username": "hyili",
                    "user_id": 19
                },
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "yacwu",
                    "user_id": 57
                },
                {
                    "username": "chenshh",
                    "user_id": 20
                },
                {
                    "username": "yanglin",
                    "user_id": 21
                },
                {
                    "username": "wangtr",
                    "user_id": 17
                },
                {
                    "username": "linsc04",
                    "user_id": 31
                },
                {
                    "username": "yaowen",
                    "user_id": 6
                },
                {
                    "username": "hchsu0426",
                    "user_id": 30
                },
                {
                    "username": "yca",
                    "user_id": 25
                },
                {
                    "username": "fuyu0425",
                    "user_id": 26
                },
                {
                    "username": "calee",
                    "user_id": 7
                },
                {
                    "username": "hcchuang",
                    "user_id": 27
                },
                {
                    "username": "hcdai",
                    "user_id": 28
                },
                {
                    "username": "yysung",
                    "user_id": 29
                },
                {
                    "username": "youwei1129",
                    "user_id": 8
                },
                {
                    "username": "zswu",
                    "user_id": 33
                },
                {
                    "username": "yahsieh",
                    "user_id": 11
                },
                {
                    "username": "syujy",
                    "user_id": 9
                },
                {
                    "username": "yenck",
                    "user_id": 34
                },
                {
                    "username": "hchou",
                    "user_id": 35
                }
            ],
            "wwwta": [
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "hyili",
                    "user_id": 19
                },
                {
                    "username": "yanglin",
                    "user_id": 21
                },
                {
                    "username": "cfhsu1993",
                    "user_id": 22
                },
                {
                    "username": "fuyu0425",
                    "user_id": 26
                },
                {
                    "username": "yoychen",
                    "user_id": 23
                },
                {
                    "username": "wlliou",
                    "user_id": 24
                },
                {
                    "username": "linsc04",
                    "user_id": 31
                },
                {
                    "username": "hcdai",
                    "user_id": 28
                },
                {
                    "username": "yysung",
                    "user_id": 29
                },
                {
                    "username": "zswu",
                    "user_id": 33
                },
                {
                    "username": "blzhuang",
                    "user_id": 18
                },
                {
                    "username": "hchou",
                    "user_id": 35
                },
                {
                    "username": "yushuen",
                    "user_id": 59
                }
            ],
            "doorta": [
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "tzuyu",
                    "user_id": 3
                },
                {
                    "username": "youwei1129",
                    "user_id": 8
                },
                {
                    "username": "wwchung",
                    "user_id": 10
                },
                {
                    "username": "wlliou",
                    "user_id": 24
                }
            ],
            "newsta": [
                {
                    "username": "lctseng",
                    "user_id": 60
                },
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "kshuang",
                    "user_id": 61
                }
            ],
            "mailta": [
                {
                    "username": "hyili",
                    "user_id": 19
                },
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "yca",
                    "user_id": 25
                },
                {
                    "username": "wangtr",
                    "user_id": 17
                },
                {
                    "username": "hchsu0426",
                    "user_id": 30
                },
                {
                    "username": "weicc",
                    "user_id": 16
                },
                {
                    "username": "hwlin1414",
                    "user_id": 15
                },
                {
                    "username": "wwchung",
                    "user_id": 10
                },
                {
                    "username": "tzute",
                    "user_id": 44
                },
                {
                    "username": "hchou",
                    "user_id": 35
                }
            ],
            "linuxta": [
                {
                    "username": "chenshh",
                    "user_id": 20
                },
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "yanglin",
                    "user_id": 21
                },
                {
                    "username": "cfhsu1993",
                    "user_id": 22
                },
                {
                    "username": "yoychen",
                    "user_id": 23
                },
                {
                    "username": "weicc",
                    "user_id": 16
                },
                {
                    "username": "calee",
                    "user_id": 7
                },
                {
                    "username": "hcchuang",
                    "user_id": 27
                },
                {
                    "username": "hcdai",
                    "user_id": 28
                },
                {
                    "username": "yysung",
                    "user_id": 29
                },
                {
                    "username": "zswu",
                    "user_id": 33
                },
                {
                    "username": "yahsieh",
                    "user_id": 11
                },
                {
                    "username": "blzhuang",
                    "user_id": 18
                },
                {
                    "username": "hchou",
                    "user_id": 35
                },
                {
                    "username": "ycliang",
                    "user_id": 39
                },
                {
                    "username": "mllee",
                    "user_id": 41
                },
                {
                    "username": "austin",
                    "user_id": 48
                },
                {
                    "username": "ctu",
                    "user_id": 45
                }
            ],
            "bsdta": [
                {
                    "username": "phdta-only",
                    "user_id": 5
                },
                {
                    "username": "yacwu",
                    "user_id": 57
                },
                {
                    "username": "hyili",
                    "user_id": 19
                },
                {
                    "username": "zjlin",
                    "user_id": 14
                },
                {
                    "username": "hwlin1414",
                    "user_id": 15
                },
                {
                    "username": "wlliou",
                    "user_id": 24
                },
                {
                    "username": "wwchung",
                    "user_id": 10
                },
                {
                    "username": "wangtr",
                    "user_id": 17
                },
                {
                    "username": "linsc04",
                    "user_id": 31
                },
                {
                    "username": "yaowen",
                    "user_id": 6
                },
                {
                    "username": "hchsu0426",
                    "user_id": 30
                },
                {
                    "username": "yca",
                    "user_id": 25
                },
                {
                    "username": "fuyu0425",
                    "user_id": 26
                },
                {
                    "username": "syujy",
                    "user_id": 9
                },
                {
                    "username": "yenck",
                    "user_id": 34
                },
                {
                    "username": "tzute",
                    "user_id": 44
                },
                {
                    "username": "jbliao",
                    "user_id": 43
                },
                {
                    "username": "youwei1129",
                    "user_id": 8
                }
            ],
            "testta": [
                {
                    "username": "zjlin",
                    "user_id": 14
                }
            ]
        }
        ', true);
    }

    public function list()
    {
        $groupedTas = $this->grouped();
        $tas = [];
        foreach ($groupedTas as $val) {
            $tas = array_merge($tas, $val);
        }
        $tas = array_values(array_unique($tas, SORT_REGULAR));
        return $tas;
    }

    public function map()
    {
        $tas = $this->list();
        $taMap = [];
        foreach ($tas as $val) {
            $taMap[$val["user_id"]] = $val["username"];
        }
        return $taMap;
    }
}
