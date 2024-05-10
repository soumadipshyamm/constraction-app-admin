<?php

return [
    'CASHIER_CURRENCY'                               => env('CASHIER_CURRENCY'),
    'STRIPE_KEY'                                     => env('STRIPE_PUBLISH_KEY'),
    'STRIPE_SECRET'                                  => env('STRIPE_SECRET_KEY'),

    'AUTHORIZE_LOGINID'                              => env('AUTHORIZE_API_LOGINID'),
    'AUTHORIZE_TRANSACTION_KEY'                      => env('AUTHORIZE_TRANSACTION_KEY'),
    'AUTHORIZE_KEY'                                  => env('AUTHORIZE_KEY'),
    'AUTHORIZE_SIGNATURE_KEY'                        => env('AUTHORIZE_SIGNATURE_KEY'),
    'AUTHORIZE_CLIENT_KEY'                           => env('AUTHORIZE_CLIENT_KEY'),

    'SITE_POST_IMAGE_DIMENSION'                    => '530xnull',
    'SITE_COLLECTION_IMAGE_DIMENSION'              => 'nullx210',
    'SITE_COVER_IMAGE_DIMENSION'                   => '1400xnull', //Exclusive Slider
    'SITE_PROFILE_IMAGE_DIMENSION'                 => '400xnull',
    'SITE_THUMBNAIL_IMAGE_DIMENSION'               => '100x100',
    'SITE_PHOTO_STORE_IMAGE_DIMENSION'             => '172x210',
    'SITE_WEBP_STORE_IMAGE_DIMENSION'              => '384x641',

    'STANDARD_IMAGE_DIMENSION' => '1920x800',  /* WxH */
    'DOUBLE_IMAGE_DIMENSION' => '3840x1600',     /* WxH */



    'SITE_ORIGINAL_IMAGE_UPLOAD_PATH'              => 'images/original/',

    'SITE_USER_IMAGE_UPLOAD_PATH'                  => 'images/original/user',
    'SITE_USER_IMAGE_THUMBNAIL_PATH'               => 'images/thumbnail/user',
    'SITE_USER_IMAGE_WEBP_PATH'                    => 'images/webp/user',

    'SITE_BOARD_IMAGE_UPLOAD_PATH'                => 'images/original/board/',
    'SITE_BOARD_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/board/',
    'SITE_BOARD_IMAGE_WEBP_PATH'                  => 'images/webp/board/',

    'SITE_BANNER_IMAGE_UPLOAD_PATH'                => 'images/original/banner/',
    'SITE_BANNER_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/banner/',
    'SITE_BANNER_IMAGE_WEBP_PATH'                  => 'images/webp/banner/',

    'SITE_CHAPTER_IMAGE_UPLOAD_PATH'                => 'images/original/chapter/',
    'SITE_CHAPTER_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/chapter/',
    'SITE_CHAPTER_IMAGE_WEBP_PATH'                  => 'images/webp/chapter/',

    'SITE_VIDEO_IMAGE_UPLOAD_PATH'                => 'images/original/video/',
    'SITE_VIDEO_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/video/',
    'SITE_VIDEO_IMAGE_WEBP_PATH'                  => 'images/webp/video/',

    'SITE_CLASS_IMAGE_UPLOAD_PATH'                => 'images/original/class/',
    'SITE_CLASS_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/class/',
    'SITE_CLASS_IMAGE_WEBP_PATH'                  => 'images/webp/class/',

    'SITE_SUBJECT_IMAGE_UPLOAD_PATH'                => 'images/original/subject/',
    'SITE_SUBJECT_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/subject/',
    'SITE_SUBJECT_IMAGE_WEBP_PATH'                  => 'images/webp/subject/',

    'SITE_BRAND_IMAGE_UPLOAD_PATH'                => 'images/original/brand/',
    'SITE_BRAND_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/brand/',
    'SITE_BRAND_IMAGE_WEBP_PATH'                  => 'images/webp/brand/',

    'SITE_BLOG_IMAGE_UPLOAD_PATH'                => 'images/original/blog/',
    'SITE_BLOG_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/blog/',
    'SITE_BLOG_IMAGE_WEBP_PATH'                  => 'images/webp/blog/',

    'SITE_CATEGORY_IMAGE_UPLOAD_PATH'              => 'images/original/category/',
    'SITE_CATEGORY_IMAGE_THUMBNAIL_PATH'           => 'images/thumbnail/category/',
    'SITE_CATEGORY_IMAGE_WEBP_PATH'                => 'images/webp/category/',

    'SITE_PRODUCT_IMAGE_UPLOAD_PATH'               => 'images/original/product/',
    'SITE_PRODUCT_IMAGE_THUMBNAIL_PATH'            => 'images/thumbnail/product/',
    'SITE_PRODUCT_IMAGE_WEBP_PATH'                 => 'images/webp/product/',

    'SITE_CV_DOCUMENT_UPLOAD_PATH'                 => 'documents/cv/',
    'SITE_AGENT_DOCUMENT_UPLOAD_PATH'              => 'images/documents/agent/',

    'SITE_CMS_IMAGE_UPLOAD_PATH'                   => 'images/cms/',

    'SITE_DOCUMENT_UPLOAD_PATH'                    => 'images/documents/',

    'SITE_WEBP_IMAGE_UPLOAD_PATH'                  => 'images/webp/',
    'SITE_POST_IMAGE_UPLOAD_PATH'                  => 'images/post/',
    'SITE_COLLECTION_IMAGE_UPLOAD_PATH'            => 'images/collection/',
    'SITE_COVER_IMAGE_UPLOAD_PATH'                 => 'images/cover/',
    'SITE_PROFILE_IMAGE_UPLOAD_PATH'               => 'images/profile/',
    'SITE_THUMBNAIL_IMAGE_UPLOAD_PATH'             => 'images/thumbnail/',
    'SITE_PHOTO_STORE_IMAGE_UPLOAD_PATH'           => 'images/photo-store/',

    'SITE_VIDEO_UPLOAD_PATH'                       => 'videos/',
    'SITE_VIDEO_TRAILER_UPLOAD_PATH'               => 'videos/trailer/',
    'SITE_VIDEO_TRAILER_CLIP_STARTING_TIME_IN_SEC' => 0,
    'SITE_VIDEO_TRAILER_CLIP_DURATION'             => 10,

    'SITE_FILE_STORAGE_DISK'                       => env('FILE_STORAGE_DISK', 's3'),

    'NO_IMAGE'                                      => 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2299%22%20height%3D%2299%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2099%2099%22%20preserveAspectRatio%3D%22none%22%3E%0A%20%20%20%20%20%20%3Cdefs%3E%0A%20%20%20%20%20%20%20%20%3Cstyle%20type%3D%22text%2Fcss%22%3E%0A%20%20%20%20%20%20%20%20%20%20%23holder%20text%20%7B%0A%20%20%20%20%20%20%20%20%20%20%20%20fill%3A%20%23000000%3B%0A%20%20%20%20%20%20%20%20%20%20%20%20font-family%3A%20sans-serif%3B%0A%20%20%20%20%20%20%20%20%20%20%20%20font-size%3A%209px%3B%0A%20%20%20%20%20%20%20%20%20%20%20%20font-weight%3A%20700%3B%0A%20%20%20%20%20%20%20%20%20%20%7D%0A%20%20%20%20%20%20%20%20%3C%2Fstyle%3E%0A%20%20%20%20%20%20%3C%2Fdefs%3E%0A%20%20%20%20%20%20%3Cg%20id%3D%22holder%22%3E%0A%20%20%20%20%20%20%20%20%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f4cea8%22%3E%3C%2Frect%3E%0A%20%20%20%20%20%20%20%20%3Cg%3E%0A%20%20%20%20%20%20%20%20%20%20%3Ctext%20text-anchor%3D%22middle%22%20x%3D%2250%25%22%20y%3D%2250%25%22%20dy%3D%22.3em%22%3ENo%20Image%20available%3C%2Ftext%3E%0A%20%20%20%20%20%20%20%20%3C%2Fg%3E%0A%20%20%20%20%20%20%3C%2Fg%3E%0A%20%20%20%20%3C%2Fsvg%3E',


    //EMAIL
    'SITE_MAIL_FROM'                               => '',
    'SITE_REPLY_TO'                                => '',
    'SITE_MAIL_GREETINGS'                          => 'Regards,',
    'SITE_MAIL_GREETINGS_FROM'                     => '',
    'SITE_NAME'                                    => '',
    'SITE_URL_FOR_MAIL'                            => '',
];
