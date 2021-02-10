<?php

include_once 'RefreshRenderer.php';

class RefreshController
{
    public function full()
    {
        echo RefreshRenderer::full();
        return true;
    }
}
