<?php

namespace Nailalliance\ShowAlternateProducts\Block;

use Magento\Catalog\Helper\Image;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Catalog\Model\ProductRepository;

class FetchProduct extends \Magento\Framework\View\Element\Template
{
    /** @var Registry */
    protected $registry;
    
    /** @var ProductRepository */
    protected $productRepository;

    /** @var Image */
    protected $_productImageHelper;

    public function __construct(
        Context $context,
        Registry $registry,
        ProductRepository $productRepository,
        Image $image,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->productRepository = $productRepository;
        $this->_productImageHelper = $image;
        parent::__construct($context, $data);
    }

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }
    
    public function loadBySku($sku)
    {
        try {
            return $this->productRepository->get($sku);
        } catch(\Exception $e) {
            return null;
        }
    }

    public function getImages($product) {
        $image = $this->_productImageHelper->init($product, 'product_base_image');
        $image1X = $image
            ->resize(200)
            ->getUrl();
        $image2X = $image
            ->resize(400)
            ->getUrl();
        return ['1x' => $image1X, '2x' => $image2X];
    }
}
