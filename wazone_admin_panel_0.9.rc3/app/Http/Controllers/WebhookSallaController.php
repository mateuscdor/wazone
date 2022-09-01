<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\User;

class WebhookSallaController extends Controller
{


    public string $json = '{
  "event": "order.created",
  "merchant": 1305146709,
  "created_at": "Sun Jun 26 2022 12:21:48 GMT+0300",
  "data": {
    "id": 2116149737,
    "reference_id": 41027662,
    "urls": {
      "customer": "https://salla.sa/dev-wofftr4xsra5xtlv/order/DXZbOz68qjnYaOw04oBa35wVELBpJyxo",
      "admin": "https://s.salla.sa/orders/order/DXZbOz68qjnYaOw04oBa35wVELBpJyxo"
    },
    "date": {
      "date": "2022-06-26 12:21:45.000000",
      "timezone_type": 3,
      "timezone": "Asia/Riyadh"
    },
    "source": "store",
    "source_device": "desktop",
    "source_details": {
      "type": "direct",
      "value": null,
      "device": "desktop",
      "user-agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36",
      "ip": "31.166.186.78"
    },
    "first_complete_at": null,
    "status": {
      "id": 566146469,
      "name": "بإنتظار المراجعة",
      "slug": "under_review",
      "customized": {
        "id": 986688842,
        "name": "بإنتظار المراجعة"
      }
    },
    "payment_method": "bank",
    "currency": "SAR",
    "amounts": {
      "sub_total": {
        "amount": 186,
        "currency": "SAR"
      },
      "shipping_cost": {
        "amount": 15,
        "currency": "SAR"
      },
      "cash_on_delivery": {
        "amount": 0,
        "currency": "SAR"
      },
      "tax": {
        "percent": "0.00",
        "amount": {
          "amount": 0,
          "currency": "SAR"
        }
      },
      "discounts": [
        {
          "title": "new offer",
          "type": "special",
          "code": "new offer",
          "discount": "5.00",
          "discounted_shipping": 0
        }
      ],
      "total": {
        "amount": 196,
        "currency": "SAR"
      }
    },
    "shipping": {
      "id": 1833934431,
      "app_id": null,
      "company": "السعودية",
      "logo": "",
      "receiver": {
        "name": "Mohammed Ali",
        "email": "usertest@gmail.com",
        "phone": "9991234%6789"
      },
      "shipper": {
        "name": "Demo",
        "company_name": "dev-wofftr4xsra5xtlv",
        "email": "wofftr4xsra5xtlv@email.partners",
        "phone": "966500000000"
      },
      "pickup_address": {
        "country": "السعودية",
        "country_code": "SA",
        "city": "مكة",
        "shipping_address": "شارع عبدالله,السلام,23233, سنابل السلام, مكة,السعودية",
        "street_number": "شارع عبدالله",
        "block": "السلام",
        "postal_code": "23233",
        "geo_coordinates": {
          "lat": 21.3825905096851,
          "lng": 39.77319103068542
        }
      },
      "address": {
        "country": "SA",
        "country_code": "SA",
        "city": "جدة",
        "shipping_address": " شارع ابو امية الضمري، الحي الزهراء ،, جدة, السعودية",
        "street_number": "ابو امية الضمري",
        "block": "الزهراء",
        "postal_code": "",
        "geo_coordinates": {
          "lat": 0,
          "lng": 0
        }
      },
      "shipment": {
        "id": "0",
        "pickup_id": null,
        "tracking_link": "0",
        "label": []
      },
      "policy_options": []
    },
    "can_cancel": true,
    "show_weight": false,
    "can_reorder": true,
    "is_pending_payment": false,
    "pending_payment_ends_at": 172796,
    "total_weight": "٠٫٢٥ كجم",
    "rating_link": "https://store-test.com/rating-link",
    "shipment_branch": [],
    "customer": {
      "id": 225167971,
      "first_name": "Mohammed",
      "last_name": "Ali",
      "mobile": 501806978,
      "mobile_code": "+966",
      "email": "usertest@gmail.com",
      "urls": {
        "customer": "https://salla.sa/dev-wofftr4xsra5xtlv/profile",
        "admin": "https://s.salla.sa/customers/l7mYBdgXA9xJwWZRZK8WD42GNkZbjvRO"
      },
      "avatar": "https://cdn.salla.sa/customer_profiles/5i6SUhu9dlF1fvL3EcV98U644eOlG9jcEipz6dOo.jpg",
      "gender": "female",
      "birthday": {
        "date": "1997-06-03 00:00:00.000000",
        "timezone_type": 3,
        "timezone": "Asia/Riyadh"
      },
      "city": "جدة",
      "country": "السعودية",
      "country_code": "SA",
      "currency": "SAR",
      "location": "",
      "updated_at": {
        "date": "2022-06-22 10:20:14.000000",
        "timezone_type": 3,
        "timezone": "Asia/Riyadh"
      }
    },
    "items": [
      {
        "id": 70815337,
        "name": "بيتزا",
        "sku": "54534534",
        "quantity": 1,
        "currency": "SAR",
        "weight": 0.25,
        "weight_label": "٠٫٢٥ كجم",
        "amounts": {
          "price_without_tax": {
            "amount": 186,
            "currency": "SAR"
          },
          "total_discount": {
            "amount": 5,
            "currency": "SAR"
          },
          "tax": {
            "percent": "0.00",
            "amount": {
              "amount": 0,
              "currency": "SAR"
            }
          },
          "total": {
            "amount": 186,
            "currency": "SAR"
          }
        },
        "notes": "",
        "product": {
          "id": 720881993,
          "type": "food",
          "promotion": {
            "title": "اطلبها ساخنه",
            "sub_title": "بيتزا خضار مشكل"
          },
          "status": "sale",
          "is_available": true,
          "sku": "54534534",
          "name": "بيتزا",
          "price": {
            "amount": 66,
            "currency": "SAR"
          },
          "sale_price": {
            "amount": 45,
            "currency": "SAR"
          },
          "currency": "SAR",
          "url": "https://salla.sa/dev-wofftr4xsra5xtlv/بيتزا/p720881993",
          "thumbnail": "https://cdn.salla.sa/bYQEn/buItWZf4OLbaTmL7vTMlDUWLOn20hfpq3QUbD2AB.jpg",
          "has_special_price": false,
          "regular_price": {
            "amount": 66,
            "currency": "SAR"
          },
          "calories": "600.00",
          "mpn": null,
          "gtin": null,
          "favorite": null,
          "starting_price": null
        },
        "options": [
          {
            "id": 1197801866,
            "product_option_id": 60176141,
            "name": "SIZE",
            "type": "checkbox",
            "value": [
              {
                "id": 408420634,
                "name": "BIG",
                "price": {
                  "amount": 120,
                  "currency": "SAR"
                }
              }
            ]
          },
          {
            "id": 289546379,
            "product_option_id": 1674915438,
            "name": "الاضافات",
            "type": "checkbox",
            "value": [
              {
                "id": 152115913,
                "name": "بصل",
                "price": {
                  "amount": 0,
                  "currency": "SAR"
                }
              },
              {
                "id": 1526610378,
                "name": "فلفل",
                "price": {
                  "amount": 0,
                  "currency": "SAR"
                }
              }
            ]
          }
        ],
        "images": [],
        "codes": [],
        "files": []
      }
    ],
    "bank": {
      "id": 326553500,
      "bank_name": "البنك الأهلي التجاري",
      "bank_id": 1473353380,
      "account_name": "Demo Account",
      "account_number": "000000608010167519",
      "iban_number": "SA2380000382608010130308",
      "status": "active"
    },
    "tags": []
  },
  "pickup_branch": {
    "id": 1345871747,
    "name": "Branch",
    "status": "active",
    "location": {
      "lat": "37.78044939",
      "lng": "-97.8503951"
    },
    "contacts": {
      "phone": "+201099999999",
      "whatsapp": "+201099999999",
      "telephone": "+201099999999"
    },
    "preparation_time": "ساعة 30 دقيقة",
    "is_open": false,
    "closest_time": {
      "from": "08:00",
      "to": "17:00"
    },
    "working_hours": [
      {
        "name": "الأحد",
        "times": [
          {
            "from": "08:00",
            "to": "17:00"
          },
          {
            "from": "19:00",
            "to": "23:30"
          }
        ]
      }
    ],
    "is_cod_available": true,
    "is_default": true,
    "type": [],
    "cod_cost": "15",
    "country": {
      "id": 1473353380,
      "name": "السعودية",
      "name_en": "Saudi Arabia",
      "code": "SA",
      "mobile_code": "+966"
    },
    "city": {
      "id": 1,
      "name": "الرياض",
      "name_en": "Riyadh"
    }
  }
}';

    /**
     * events and action method
     */
    protected const WEBHOOK_EVENTS = [
        "abandoned.cart" => "abandonedCart",
        "order.created" => "orderCreated",
        "order.status.updated" => "orderStatusUpdated",
        "order.cancelled" => "orderCancelled",
        "order.refunded" => "orderRefunded",
        "order.deleted" => "orderDeleted",
        "order.total.price.updated" => "orderTotalPriceUpdated",
    ];

    /**
     * variables tmp replacement
     */
    protected const VARIABLES = [
        "client_name" => '{اسم العميل}',
        "product_name" => '{اسم المنتج}',
        "order_id" => '{رقم الطلب}',
        "order_url" => '{رابط معلومات الطلب}',
        "order_amount" => '{قيمة الطلب}',
        "order_status" => '{حالة الطلب}',
        "order_currency" => '{العملة}',
        "order_shipping_company" => '{شركة الشحن}',
        "order_shipment_id" => '{رقم التتبع}',
        "order_tracking_link" => '{رابط التتبع}',
        "product_id" => '{كود المنتج}'
    ];



    /**
     *
     * create user comes from salla
     *
     * @param $json
     * @return void
     *
     */
    public function createUser($json): void
    {
        //create user
    }

    /**
     *
     * check is webhook salla
     *
     * @param string $authorization
     * @return bool
     */
    public function isWebhook(string $authorization): bool
    {
        return true;
    }

    /**
     *
     * check is salla wazone user
     *
     * @param int $merchant_id
     * @return bool
     */
    public function isUser(int $merchant_id): bool
    {
        return true;
    }

    /**
     *
     * check and validate event and found in database
     *
     * @param string $event
     * @return bool
     */
    public function isEvent(string $event): bool
    {
        $tmpName = $this->getTmpName($event);
        return true;
    }

    /**
     *
     * get tmp name of event
     *
     * @param string $event
     * @return string
     */
    public function getTmpName(string $event): string
    {
        return self::WEBHOOK_EVENTS[$event];
    }


    /**
     *
     * return array of data to replacement with variables in tmp
     *
     * @param array $jsonArr
     * @return array
     *
     */
    public function getValuesData(array $dataArray): array
    {
        $valuesArr = [
            "client_name" => $dataArray["data"]["order"]["customer"] . " " . $dataArray["data"]["customer"]["last_name"],
            "product_name" => $dataArray["data"]["items"][0]["name"],
            "order_id" => $dataArray["data"]["reference_id"] ?: '',
            "order_url" => $dataArray["data"]["items"][0]["product"]["url"],
            "order_amount" => $dataArray["data"]["items"][0]["amounts"]["total"]["amount"],
            "order_status" => $dataArray["data"]["status"]["customized"]["name"],
            "order_currency" => $dataArray["data"]["currency"],
            "order_shipping_company" => $dataArray["data"]["shipping"]["company"],
            "order_shipment_id" => $dataArray["data"]["shipping"]["id"],
            "order_tracking_link" => $dataArray["data"]["shipping"]["shipment"]["tracking_link"],
            "product_id" => $dataArray["data"]["items"][0]["product"]["id"],
        ];
        return $valuesArr;
    }

    /**
     *
     * do webhook action
     *
     * @param $json
     * @return void
     *
     */
    public function webhookAction(): void
    {

        $data = json_decode($this->json, true);
        $authorization = "true";
        $merchant_id = $data["merchant"];
        $event = $data["event"];

        if ($this->isWebhook($authorization) && $this->isUser($merchant_id) && $this->isEvent($event)){
//            echo "<pre>";
//            print_r($data);
//            echo "</pre>";
//            exit();
            // get webhook event tmp
            $tmpName = $this->getTmpName($event);

            //get tmp of event of user record
            $user_id = User::where('marchant_id', $merchant_id)->first();
            $template = Template::where('name', $tmpName)->where('user_id', $user_id->id)->first();

            // create array of data to replacement with variables
            $valuesArr = $this->getValuesData($data);

            // message sent
            $message = str_replace(self::VARIABLES, $valuesArr, $template->msgtext);

            // send to out box
            var_dump($message);



        }
    }



}
