<template>
<div class="offcanvas offcanvas-start canvas-filter" id="filterShop">
        <div class="canvas-wrapper">
            <div class="canvas-header">
                <h5>Filters</h5>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </div>
            <div class="canvas-body">
                <div class="widget-facet facet-categories">
                    <h6 class="facet-title">Product Categories</h6>
                    <ul class="facet-content">
                        <li><a href="#" class="categories-item">Bags <span class="count-cate">(112)</span></a></li>
                        <li><a href="#" class="categories-item">Booking <span class="count-cate">(32)</span> </a></li>
                        <li><a href="#" class="categories-item">Clothing <span class="count-cate">(42)</span></a></li>
                        <li><a href="#" class="categories-item active">Women <span class="count-cate">(65)</span></a></li>
                        <li><a href="#" class="categories-item">Men <span class="count-cate">(13)</span></a></li>
                        <li><a href="#" class="categories-item">Shoes <span class="count-cate">(52)</span></a></li>
                        <li><a href="#" class="categories-item">Uncategorized <span class="count-cate">(14)</span></a></li>
                    </ul>
                </div>
                <div class="widget-facet facet-price">
                    <h6 class="facet-title">Price</h6>
                    <div class="price-val-range" id="price-value-range" data-min="0" data-max="500"></div>
                    <div class="box-price-product">
                        <div class="box-price-item">
                            <span class="title-price">Min price</span>
                            <div class="price-val" id="price-min-value" data-currency="$"></div>
                        </div>
                        <div class="box-price-item">
                            <span class="title-price">Max price</span>
                            <div class="price-val" id="price-max-value" data-currency="$"></div>
                        </div>
                    </div>
                </div>
                <div class="widget-facet facet-size">
                    <h6 class="facet-title">Size</h6>
                    <div class="facet-size-box size-box">
                        <span class="size-item size-check">XS</span>
                        <span class="size-item size-check">S</span>
                        <span class="size-item size-check">M</span>
                        <span class="size-item size-check">L</span>
                        <span class="size-item size-check">XL</span>
                        <span class="size-item size-check">2XL</span>
                        <span class="size-item size-check">3XL</span>
                        <span class="size-item size-check free-size">Free Size</span>
                    </div>
                </div>
                <div class="widget-facet facet-color">
                    <h6 class="facet-title">Colors</h6>
                    <div class="facet-color-box">
                        <div class="color-item color-check"><span class="color bg-light-pink-2"></span>Pink</div>
                        <div class="color-item color-check"><span class="color bg-red"></span> Red</div>
                        <div class="color-item color-check"><span class="color bg-beige-2"></span>Beige</div>
                        <div class="color-item color-check"><span class="color bg-orange-2"></span>Orange</div>
                        <div class="color-item color-check"><span class="color bg-light-green"></span>Green</div>
                        <div class="color-item color-check"><span class="color bg-main"></span>Black</div>
                        <div class="color-item color-check"><span class="color bg-white line-black"></span>White</div>
                        <div class="color-item color-check"><span class="color bg-purple-3"></span>Purple</div>
                        <div class="color-item color-check"><span class="color bg-grey"></span>Grey</div>
                        <div class="color-item color-check"><span class="color bg-light-blue-5"></span>Light Blue</div>
                        <div class="color-item color-check"><span class="color bg-dark-blue"></span>Dark Blue</div>            
                    </div>
                </div>
                <div class="widget-facet facet-fieldset">
                    <h6 class="facet-title">Availability</h6>
                    <div class="box-fieldset-item">
                        <fieldset class="fieldset-item">
                            <input type="radio" name="availability" class="tf-check" id="inStock">
                            <label for="inStock">In stock <span class="count-stock">(32)</span></label>
                        </fieldset>
                        <fieldset class="fieldset-item">
                            <input type="radio" name="availability" class="tf-check" id="outStock">
                            <label for="outStock">Out of stock <span class="count-stock">(2)</span></label>
                        </fieldset>
                    </div>
                </div>
                <div class="widget-facet facet-fieldset">
                    <h6 class="facet-title">Brands</h6>
                    <div class="box-fieldset-item">
                        <fieldset class="fieldset-item">
                            <input type="checkbox" name="brand" class="tf-check" id="nike">
                            <label for="nike">Nike <span class="count-brand">(112)</span></label>
                        </fieldset>
                        <fieldset class="fieldset-item">
                            <input type="checkbox" name="brand" class="tf-check" id="LV">
                            <label for="LV">Louis Vuitton <span class="count-brand">(2)</span></label>
                        </fieldset>
                        <fieldset class="fieldset-item">
                            <input type="checkbox" name="brand" class="tf-check" id="hermes">
                            <label for="hermes">Hermes <span class="count-brand">(42)</span></label>
                        </fieldset>
                        <fieldset class="fieldset-item">
                            <input type="checkbox" name="brand" class="tf-check" id="gucci">
                            <label for="gucci">Gucci <span class="count-brand">(13)</span></label>
                        </fieldset>
                        <fieldset class="fieldset-item">
                            <input type="checkbox" name="brand" class="tf-check" id="zalando">
                            <label for="zalando">Zalando <span class="count-brand">(54)</span></label>
                        </fieldset>
                        <fieldset class="fieldset-item">
                            <input type="checkbox" name="brand" class="tf-check" id="adidas">
                            <label for="adidas">Adidas <span class="count-brand">(93)</span></label>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="canvas-bottom">
                <button id="reset-filter" class="tf-btn btn-reset">Reset Filters</button>
            </div>
        </div>
    </div>
</template>
