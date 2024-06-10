<?php

namespace alirezax5\Zarinpal;
class ErrorMessage
{
    private $errorArr = [
        "-1" => "اطلاعات ارسال شده ناقص است.",
        "-2" => "IP و يا مرچنت كد پذيرنده صحيح نيست",
        "-3" => "با توجه به محدوديت هاي شاپرك امكان پرداخت با رقم درخواست شده ميسر نمي باشد",
        "-4" => "سطح تاييد پذيرنده پايين تر از سطح نقره اي است.",
        "-11" => "درخواست مورد نظر يافت نشد.",
        "-12" => "امكان ويرايش درخواست ميسر نمي باشد.",
        "-21" => "هيچ نوع عمليات مالي براي اين تراكنش يافت نشد",
        "-22" => "تراكنش نا موفق ميباشد",
        "-33" => "رقم تراكنش با رقم پرداخت شده مطابقت ندارد",
        "-34" => "سقف تقسيم تراكنش از لحاظ تعداد يا رقم عبور نموده است",
        "-40" => "اجازه دسترسي به متد مربوطه وجود ندارد.",
        "-41" => "اطلاعات ارسال شده مربوط به AdditionalData غيرمعتبر ميباشد.",
        "-42" => "مدت زمان معتبر طول عمر شناسه پرداخت بايد بين 30 دقيه تا 45 روز مي باشد.",
        "-54" => "درخواست مورد نظر آرشيو شده است",
        "100" => "عمليات با موفقيت انجام گرديده است.",
        "101" => "عمليات پرداخت موفق بوده و قبلا PaymentVerification تراكنش انجام شده است.",
    ];
    private $code;
    private $desc;
    private $cb;
    private $request;

    public function __construct($code, $desc, $cb, $request = false)
    {
        $this->code = $code;
        $this->desc = $desc;
        $this->cb = $cb;
        $this->request = $request;
    }

    public function msg()
    {
        if (empty($this->cb) && $this->request === true)
            return "لینک بازگشت ( CallbackURL ) نباید خالی باشد";


        if (empty($this->desc) && $this->request === true)
            return "توضیحات تراکنش ( Description ) نباید خالی باشد";


        return array_key_exists("{$this->code}", $this->errorArr) ? $this->errorArr["{$this->code}"] : 'خطای نامشخص هنگام اتصال به درگاه زرین پال';
    }
}