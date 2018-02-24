<?php

namespace app\migrations;

class DefaultContent
{
//  style="float:right"
    const CONTENT_IMAGE = <<<HTML
<a href="/upload/images/15191356815a8c2bc17ad332.97335651.png" target="_blank">
    <img alt="" class="thumbnail" src="/upload/images/thumbnail/15191356815a8c2bc17ad332.97335651.png"{style} />
</a>
HTML;
    const CONTENT_SHORT = <<<HTML
<p>{image}
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
fugiat nulla pariatur.
</p>
HTML;
    const CONTENT_FULL = <<<HTML
<h1>{title}</h1>
{short}
{full}
HTML;

}