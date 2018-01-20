<?php
require_once(__DIR__ . '/../TemplateHelper.php');
require_once(__DIR__ . '/ViewBase.php');

class AttachmentView extends ViewBase
{
    public function renderAttachment($attachment){
        header("Content-type: $attachment->mimeType");
        echo $attachment->data;
    }

    public function renderAttachmentResized($attachment, $size) {
        require_once(__DIR__ . '/../core/smart_resize_image.function.php');
        smart_resize_image(null, $attachment->data, $size, $size,true,'browser',false,false,100);
    }

    public function renderGearUploadAttachment($userId, $id, $attachmentTypes) {
        global $lang;
        $title = $lang['addAttachments'];
        TemplateHelper::renderHeader($title);

        $select_attachmentType = '';
        foreach ($attachmentTypes as $attachmentType) {
            $select_attachmentType .= "<option value=\"$attachmentType->id\">$attachmentType->title</option>";
        }

        echo <<< GEARADD
        <h3>
            {$title}
        </h3>
        <form action="../process" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="typeId">{$lang['category']}</label>
            <select class="form-control" name="typeId">
            {$select_attachmentType}
            </select>
        </div>
        <div class="form-group">
            <label for="uploadPicture">{$lang['description']}</label>
            <input type="hidden" class="form-control" name="userId" value="{$userId}">
            <input type="hidden" class="form-control" name="gearId" value="{$id}">
            <input type="text" class="form-control" name="attachmentDescription">
            <label for="uploadPicture">{$lang['picture']}</label>
            <input type="file" class="form-control" name="attachmentData">
        </div>
        <button type="submit" class="btn btn-default">Upload</button>
        </form>
GEARADD;
        TemplateHelper::renderFooter();
    }

}
