<?php

namespace SilverStripe\Lessons;

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\AssetAdmin\Forms\UploadField;

use SilverStripe\Versioned\Versioned;

class Region extends DataObject
{
    private static $table_name = 'Region';

    private static $db = [
        'Title' => 'Varchar',
        'Description' => 'Text',
    ];

    private static $has_one = [
        'Photo' => Image::class,
        'RegionsPage' => RegionsPage::class,
    ];

    private static $owns = [
        'Photo',
    ];

    private static $extensions = [
        Versioned::class,
    ]; 

    //GridField isn't offering us anything in the way of publication. All we have are "Save" and "Delete" buttons. To get the full array of publishing actions ("Save", "Publish", "Archive", etc.
    private static $versioned_gridfield_extensions = true;

    private static $summary_fields = [
        'GridThumbnail' => '',
        // 'Photo.Filename' => 'Photo file name',
        'Title' => 'Title of region',
        'Description' => 'Short description'
    ];

    public function getGridThumbnail()
    {
        if($this->Photo()->exists()) {
            return $this->Photo()->ScaleWidth(100);
        }

        return "(no image)";
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Title'),
            TextareaField::create('Description'),
            $uploader = UploadField::create('Photo')
        );

        $uploader->setFolderName('region-photos');
        $uploader->getValidator()->setAllowedExtensions(['png','gif','jpeg','jpg']);

        return $fields;
    }
}