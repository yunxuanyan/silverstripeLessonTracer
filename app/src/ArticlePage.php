<?php

namespace SilverStripe\Lessons;

use Page;

use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ArticlePage extends Page
{
  private static $can_be_root = false;

    private static $table_name = 'ArticlePage';
    
    private static $db = [
        'Date' => 'Date',
        'Teaser' => 'Text',
        'Author' => 'Varchar',
    ];

    private static $has_one = [
        'Photo' => Image::class,
        'Brochure' => File::class
    ];

    private static $owns = [
      'Photo',
      'Brochure',
  ];
    
      public function getCMSFields()
      {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', DateField::create('Date','Date of article'), 'Content');
        $fields->addFieldToTab('Root.Main', TextareaField::create('Teaser')
         ->setDescription('This is the summary that appears on the article list page.'),
            'Content'
        );
        $fields->addFieldToTab('Root.Main', TextField::create('Author','Author of article'),'Content');
    
        $fields->addFieldToTab('Root.Attachments', $photo = UploadField::create('Photo'));
        $fields->addFieldToTab('Root.Attachments', $brochure = UploadField::create('Brochure','Travel brochure, optional (PDF only)'));

        $photo->setFolderName('travel-photos');
        $brochure
          ->setFolderName('travel-brochures')
          ->getValidator()->setAllowedExtensions(array('pdf'));

        return $fields;
      }
}