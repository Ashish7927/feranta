<div class="col-lg-3 col-12 sidebar-let">
                        <div class="blog-left-side widget">
                            <div class="widget widget_categories border_radius">
                                <h3 class="widget-title fw_600 mb-3">Categories</h3>
                                <ul class="list-group">
                                    <?php foreach($category_data as $cat): 
                                            $subcat = $this->db->query("SELECT * FROM category  where parent_id='$cat->cat_id' AND status='1'")->getResult();
                                        ?>
                                    <li class="cat-item"><a href="<?= base_url(); ?>/Shop/<?= $cat->cat_id; ?>" class="txt_blue mb-2"><span class="mdi mdi-chevron-double-right"></span><?= $cat->cat_name ?></span></a>
                                        
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                
                                

                            </div>
                            
                            <div class="price-filter d-flex border_radius">
                                <div class="wrapper">
                                    <h3 class="widget-title fw_600 mb-3">Price</h3>
                                    <div class="price-input">
                                        <div class="field">
                                            <span>Min</span>
                                            <input type="number" class="input-min border_solid border_radius txt_blue" value="2500">
                                        </div>
                                        <div class="field ms-2 ms-md-4">
                                            <span>Max</span>
                                            <input type="number" class="input-max border_solid border_radius txt_blue" value="7500">
                                        </div>
                                    </div>
                                    <div class="price-slider">
                                        <div class="progress"></div>
                                    </div>
                                    <div class="range-input">
                                        <input type="range" class="range-min" min="0" max="10000" value="2500" step="100">
                                        <input type="range" class="range-max" min="0" max="10000" value="7500" step="100">
                                    </div>
                                </div>
                            </div>
                           
                            
                        </div>
                    </div>