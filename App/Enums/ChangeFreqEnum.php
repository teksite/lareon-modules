<?php

namespace Lareon\Modules\Seo\App\Enums;

enum ChangeFreqEnum: string
{
    case HOURLY = "hourly";
    case DAILY = "daily";
    case WEEKLY = "weekly";
    case MONTHLY = "monthly";
    case YEARLY = "yearly";
    case NEVER = "never";
    case ALWAYS = "always";
}
