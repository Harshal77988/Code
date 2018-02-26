<div class="sidebar">
    <ul class="sidebar-nav">
        <li class="<?=($this->uri->segment(1) == "admin" && $this->uri->segment(2) == "" ? 'active button open' : '')?>">
            <a href="<?=base_url('admin')?>">
                <i class="fa fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="<?=($this->uri->segment(2) == "customers" ? 'active button open' : '')?>">
            <a href="<?=base_url('auth/customers')?>">
                <i class="fa fa-user"></i>
                <span>Customers</span>
            </a>
        </li>

        <!-- navigation tabs for buy section start -->
        <li class="title">Buy</li>
        <li class="dropdown <?=($this->uri->segment(2) == "products" || $this->uri->segment(2) == "edit_buy_products" || $this->uri->segment(2) == "edit_buy_attribute" || $this->uri->segment(2) == "add_products" || $this->uri->segment(2) == "buy_categories" || $this->uri->segment(2) == "buy_sub_categories" || $this->uri->segment(2) == "buy_attributes" || $this->uri->segment(2) == "import_categories" || $this->uri->segment(2) == "import_products" || $this->uri->segment(2) == "import_brands" || $this->uri->segment(2) == "addBuyAttribute" || $this->uri->segment(2) == "import_attributes" || $this->uri->segment(2) == "buy_brands" ? 'active open' : '')?>">
            <a href="#" data-click="prevent">
                <i class="fa fa-shopping-cart"></i>
                <span>Catalog</span>
            </a>
            <ul class="inner-nav">
                <li class="<?=($this->uri->segment(2) == "products" || $this->uri->segment(2) == "add_products" || $this->uri->segment(2) == "import_products" || $this->uri->segment(2) == "edit_buy_products" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/products')?>">
                        Products
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "buy_categories" || $this->uri->segment(2) == "import_categories" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/buy_categories')?>">
                        Categories
                    </a>
                </li>
                <!-- <li class="<?=($this->uri->segment(2) == "buy_sub_categories" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/buy_sub_categories')?>">
                        Sub-Categories
                    </a>
                </li> -->
                <li class="<?=($this->uri->segment(2) == "buy_brands" || $this->uri->segment(2) == "import_brands" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/buy_brands')?>">
                        Brands
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "buy_attributes" || $this->uri->segment(2) == "edit_buy_attribute" || $this->uri->segment(2) == "buy_attributes" || $this->uri->segment(2) == "addBuyAttribute" || $this->uri->segment(2) == "import_attributes" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/buy_attributes')?>">
                        Attributes
                    </a>
                </li>
            </ul>
        </li>
        <li class="<?=($this->uri->segment(2) == "orders" || $this->uri->segment(2) == "order_details" || $this->uri->segment(2) == "admin_order_details" ? 'active open' : '')?>">
            <a href="<?=base_url('admin/orders')?>">
                <i class="fa fa-bar-chart"></i>
                <span>Orders</span>
            </a>
        </li>
        <!-- navigation tabs for buy section end -->

        <!-- navigation tabs for rent section start -->
        <li class="title">Rent</li>
        <li class="dropdown <?=($this->uri->segment(2) == "rent_products" || $this->uri->segment(2) == "add_rent_products" || $this->uri->segment(2) == "rent_categories" || $this->uri->segment(2) == "rent_subcategories" ? 'active open' : '')?>">
            <a href="#" data-click="prevent">
                <i class="fa fa-shopping-cart"></i>
                <span>Catalog</span>
            </a>
            <ul class="inner-nav">
                <li class="<?=($this->uri->segment(2) == "rent_products" || $this->uri->segment(2) == "add_rent_products" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/rent_products')?>">
                        Products
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "rent_categories" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/rent_categories')?>">
                        Categories
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "rent_subcategories" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/rent_subcategories')?>">
                        Sub-Categories
                    </a>
                </li>
            </ul>
        </li>
        <li class="<?=($this->uri->segment(2) == "rent_orders" || $this->uri->segment(2) == "rent_order_details" ? 'active button open' : '')?>">
            <a href="<?=base_url('admin/rent_orders')?>">
                <i class="fa fa-bar-chart"></i>
                <span>Orders</span>
            </a>
        </li>
        <!-- navigation tabs for rent section end -->

        <!-- navigation tabs for pre-order section start -->
        <li class="title">Pre-order</li>
        <li class="<?=($this->uri->segment(2) == "pre_orders" || $this->uri->segment(2) == "pre_order_details" ? 'active button open' : '')?>">
            <a href="<?=base_url('admin/pre_orders')?>">
                <i class="fa fa-bar-chart"></i>
                <span>Manage Pre-Orders</span>
            </a>
        </li>
        <!-- navigation tabs for pre-order section end -->

        <li class="title">Other</li>
        <li class="<?=($this->uri->segment(2) == "taxes" ? 'active button open' : '')?>">
            <a href="<?=base_url('admin/taxes')?>">
                <i class="fa fa-percent"></i>
                <span>Manage Taxes</span>
            </a>
        </li>
        <li class="<?=($this->uri->segment(2) == "coupons" ? 'active button open' : '')?>">
            <a href="<?=base_url('admin/coupons')?>">
                <i class="fa fa-ticket"></i>
                <span>Manage Coupons</span>
            </a>
        </li>
        <li class="<?=($this->uri->segment(2) == "notification" ? 'active button open' : '')?>">
            <a href="<?=base_url('admin/notification')?>">
                <i class="fa fa-ticket"></i>
                <span>Manage Notifications</span>
            </a>
        </li>
        <li class="dropdown <?=($this->uri->segment(2) == "daily_reports" || $this->uri->segment(2) == "quarterly_reports" || $this->uri->segment(2) == "weekly_reports" || $this->uri->segment(2) == "monthly_reports" || $this->uri->segment(2) == "yearly_reports" || $this->uri->segment(2) == "sales_report" ? 'active open' : '')?>">
            <a href="#" data-click="prevent">
                <i class="fa fa-bar-chart"></i>
                <span>Reports</span>
            </a>
            <ul class="inner-nav">
                <li class="<?=($this->uri->segment(2) == "daily_reports" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/daily_reports')?>">
                        Daily Orders
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "weekly_reports" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/weekly_reports')?>">
                        Weekly Orders
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "monthly_reports" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/monthly_reports')?>">
                        Monthly Orders
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "quarterly_reports" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/quarterly_reports')?>">
                        Quarterly Orders
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "yearly_reports" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/yearly_reports')?>">
                        Yearly Orders
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "sales_report" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/sales_report')?>">
                        Sales Report
                    </a>
                </li>
            </ul>
        </li>
        <li class=" dropdown <?=($this->uri->segment(2) == "blog_list" || $this->uri->segment(2) == "view_blog" || $this->uri->segment(2) == "blog_categories_list" || $this->uri->segment(2) == "add_blog" || $this->uri->segment(2) == "edit_blog" || $this->uri->segment(2) == "add_blog_categories" || $this->uri->segment(2) == "edit_blog_categories"  ? 'active open' : '')?>">
            <a href="#" data-click="prevent">
                <i class="fa fa-list-alt"></i>
                <span>Blogs</span>
            </a>
            <ul class="inner-nav">
                <li class="<?=($this->uri->segment(2) == "blog_list" || $this->uri->segment(2) == "view_blog" || $this->uri->segment(2) == "add_blog" || $this->uri->segment(2) == "edit_blog" ? 'active' : '')?>">
                    <a href="<?=base_url('admin/blog_list')?>">
                        Manage Blog
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "blog_categories_list" || $this->uri->segment(2) == "add_blog_categories" || $this->uri->segment(2) == "edit_blog_categories"  ? 'active' : '')?>">
                    <a href="<?=base_url('admin/blog_categories_list')?>">
                        Blog Categories
                    </a>
                </li>
               
            </ul>
        </li>
        <li class="<?=($this->uri->segment(2) == "newsletter" ? 'active button open' : '')?>">
            <a href="<?=base_url('admin/newsletter')?>">
                <i class="fa fa-bullhorn"></i>
                <span>Newsletter</span>
            </a>
        </li>
        <li class=" dropdown <?=($this->uri->segment(2) == "highlight_products" || $this->uri->segment(2) == "manage_cms" || $this->uri->segment(2) == "edit_cms_page" || $this->uri->segment(2) == "dow_products" || $this->uri->segment(2) == "edit_dow_product" || $this->uri->segment(2) == "edit_highlighted_product" || $this->uri->segment(2) == "landing_page_slider_cms" || $this->uri->segment(2) == "manage_social_links" || $this->uri->segment(2) == "manage_cms" || $this->uri->segment(2) == "manage_footer" ? 'active open' : '')?>">
            <a href="#" data-click="prevent">
                <i class="fa fa-clone"></i>
                <span>CMS</span>
            </a>
            <ul class="inner-nav">
                <li class="<?=($this->uri->segment(2) == "landing_page_slider_cms" ? 'active' : '')?>"">
                    <a href="<?=base_url().'admin/landing_page_slider_cms';?>">
                        Landing Page CMS
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "highlight_products" || $this->uri->segment(2) == "edit_highlighted_product" ? 'active' : '')?>"">
                    <a href="<?=base_url().'admin/highlight_products';?>">
                        Highlight Products
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "dow_products" || $this->uri->segment(2) == "edit_dow_product" ? 'active' : '')?>"">
                    <a href="<?=base_url().'admin/dow_products';?>">
                        Deals of the Week
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "manage_footer" || $this->uri->segment(2) == "update_footer_cms" ? 'active' : '')?>"">
                    <a href="<?=base_url().'admin/manage_footer';?>">
                        Manage Footer
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "manage_cms" || $this->uri->segment(2) == "edit_cms_page" || $this->uri->segment(2) == "update_cms" ? 'active' : '')?>"">
                    <a href="<?=base_url().'admin/manage_cms';?>">
                        Manage Pages
                    </a>
                </li>
                <li class="<?=($this->uri->segment(2) == "manage_social_links" || $this->uri->segment(2) == "update_social_links" ? 'active' : '')?>"">
                    <a href="<?=base_url().'admin/manage_social_links';?>">
                        Manage Social Links
                    </a>
                </li>
            </ul>
        </li>
        <li class="">
            <a href="#" data-click="prevent">
                <i class="fa fa-shopping-bag"></i>
                <span>Marketing</span>
            </a>
        </li>
    </ul>
</div>