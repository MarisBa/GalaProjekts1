@extends('layouts.app')
@section('content')

<div class="container-fluid py-4">
    
    <div class="row">
        <!-- Sidebar Column -->
        @include('ads.sidebar')

        <!-- Main Content Column -->
        <div class="col-lg-9">
            @if($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @foreach ($errors->all() as $errorMessage)
                        <li>{{ $errorMessage }}</li>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data">

                @csrf
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Post Your Ad</h4>
                        <p class="small mb-0">Fill in all required fields to create your listing</p>
                    </div>
                    
                    <div class="card-body">
                        <!-- Images Section -->
                        <div class="form-section">
                            <h5 class="section-title">Upload Images</h5>
                            <p class="section-subtitle">First image will be featured (max 3MB each)</p>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="image-upload-card" onclick="document.getElementById('feature_image').click()">
                                        <div class="upload-placeholder">
                                            <i class="fas fa-camera fa-2x"></i>
                                            <span>Main Image</span>
                                        </div>
                                        <img id="feature_image_preview" class="preview-image" style="display:none;">
                                        <input type="file" name="feature_image" id="feature_image" style="display:none;" onchange="previewImage(this, 'feature_image_preview')">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="image-upload-card" onclick="document.getElementById('first_image').click()">
                                        <div class="upload-placeholder">
                                            <i class="fas fa-camera fa-2x"></i>
                                            <span>Second Image</span>
                                        </div>
                                        <img id="first_image_preview" class="preview-image" style="display:none;">
                                        <input type="file" name="first_image" id="first_image" style="display:none;" onchange="previewImage(this, 'first_image_preview')">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="image-upload-card" onclick="document.getElementById('second_image').click()">
                                        <div class="upload-placeholder">
                                            <i class="fas fa-camera fa-2x"></i>
                                            <span>Third Image</span>
                                        </div>
                                        <img id="second_image_preview" class="preview-image" style="display:none;">
                                        <input type="file" name="second_image" id="second_image" style="display:none;" onchange="previewImage(this, 'second_image_preview')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Category Section -->
                        <div class="form-section">
                            <h5 class="section-title">Category Information</h5>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select class="form-control select2" name="category_id" id="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach (App\Models\Category::all() as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subcategory_id">Subcategory</label>
                                        <select class="form-control select2" name="subcategory_id" id="subcategory_id" required>
                                            <option value="">Select Subcategory</option>
                                            <!-- Subcategories will be loaded dynamically -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="childcategory_id">Child Category</label>
                                        <select class="form-control select2" name="childcategory_id" id="childcategory_id">
                                            <option value="">Select Child Category</option>
                                            <!-- Child categories will be loaded dynamically -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h5 class="section-title">Basic Information</h5>
                            
                            <div class="form-group">
                                <label for="name">Ad Title</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter a descriptive title">
                                <small class="form-text text-muted">Make it clear and descriptive to attract buyers</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="mytextarea" class="form-control" rows="5" placeholder="Provide detailed information about the item"></textarea>
                                <small class="form-text text-muted">Include condition, features, reason for selling, etc.</small>
                            </div>
                        </div>
                        
                        <!-- Pricing Section -->
                        <div class="form-section">
                            <h5 class="section-title">Pricing Details</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" name="price" id="price" class="form-control" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price_status">Price Status</label>
                                        <select class="form-control" name="price_status" id="price_status">
                                            <option value="negoitable">Negotiable</option>
                                            <option value="fixed">Fixed Price</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Condition Section -->
                        <div class="form-section">
                            <h5 class="section-title">Item Condition</h5>
                            
                            <div class="form-group">
                                <select class="form-control" name="product_condition" id="product_condition">
                                    <option value="">Select Condition</option>
                                    <option value="new">Brand New</option>
                                    <option value="likenew">Like New</option>
                                    <option value="good">Good</option>
                                    <option value="fair">Fair</option>
                                    <option value="heavilyused">Heavily Used</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Location Section -->
                        <div class="form-section">
                            <h5 class="section-title">Location Details</h5>
                            
                            <div class="form-group">
                                <label for="listing_location">Listing Location</label>
                                <input type="text" class="form-control" name="listing_location" id="listing_location" placeholder="Enter specific location">
                            </div>
                            
                            <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country_id">Country</label>
                                    <select class="form-control select2" name="country_id" id="country_id" required>
                                        <option value="">Select Country</option>
                                        @foreach (App\Models\Country::all() as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state_id">State/Region</label>
                                    <select class="form-control select2" name="state_id" id="state_id" required>
                                        <option value="">Select State/Region</option>
                                        <!-- States will be loaded dynamically -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_id">City</label>
                                    <select class="form-control select2" name="city_id" id="city_id">
                                        <option value="">Select City</option>
                                        <!-- Cities will be loaded dynamically -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="form-section">
                            <h5 class="section-title">Contact Information</h5>
                            
                            <div class="form-group">
                                <label for="phone_number">Contact Number</label>
                                <input type="number" class="form-control" name="phone_number" id="phone_number" placeholder="Enter phone number for buyers">
                                <small class="form-text text-muted">This will be displayed on your ad</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="link">Demo Link (YouTube, etc.)</label>
                                <input type="text" class="form-control" name="link" id="link" placeholder="https://youtube.com/example">
                                <small class="form-text text-muted">Optional - include a video demonstration</small>
                            </div>
                        </div>
                        
                        <!-- Submit Section -->
                        <div class="form-section text-right">
                            <button class="btn btn-outline-secondary mr-2" type="reset">Reset</button>
                            <button class="btn btn-primary px-4" type="submit">
                                <i class="fas fa-paper-plane mr-2"></i> Publish Ad
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-color: #f72585;
        --light-gray: #f8f9fa;
        --dark-gray: #6c757d;
        --border-radius: 8px;
        --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s ease;
    }
    
    body {
        background-color: #f5f7fb;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: #333;
    }
    
    /* Profile Card Styles */
    .profile-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
    }
    
    .avatar-container {
        width: 130px;
        height: 130px;
        margin: 0 auto;
        position: relative;
    }
    
    .avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .profile-name {
        font-weight: 700;
        margin-top: 15px;
        color: #2b2d42;
    }
    
    /* Sidebar Menu Styles */
    .sidebar-menu {
        padding: 10px 0;
    }
    
    .sidebar-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #495057;
        text-decoration: none;
        transition: var(--transition);
        border-left: 3px solid transparent;
    }
    
    .sidebar-item i {
        width: 24px;
        text-align: center;
        margin-right: 10px;
        color: var(--dark-gray);
    }
    
    .sidebar-item:hover, .sidebar-item.active {
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
        border-left: 3px solid var(--primary-color);
    }
    
    .sidebar-item:hover i, .sidebar-item.active i {
        color: var(--primary-color);
    }
    
    /* Form Card Styles */
    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-bottom: 30px;
    }
    
    .card-header {
        background-color: var(--primary-color);
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        padding: 20px 25px;
    }
    
    /* Form Section Styles */
    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2b2d42;
        margin-bottom: 5px;
    }
    
    .section-subtitle {
        font-size: 0.85rem;
        color: var(--dark-gray);
        margin-bottom: 15px;
    }
    
    /* Image Upload Styles */
    .image-upload-card {
        border: 2px dashed #ddd;
        border-radius: var(--border-radius);
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        background-color: #fafafa;
        position: relative;
        overflow: hidden;
    }
    
    .image-upload-card:hover {
        border-color: var(--primary-color);
        background-color: rgba(67, 97, 238, 0.05);
    }
    
    .upload-placeholder {
        text-align: center;
        color: var(--dark-gray);
        z-index: 1;
    }
    
    .upload-placeholder i {
        display: block;
        margin-bottom: 10px;
        color: #adb5bd;
    }
    
    .preview-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Form Control Styles */
    .form-control {
        border-radius: var(--border-radius);
        padding: 10px 15px;
        border: 1px solid #e0e0e0;
        transition: var(--transition);
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    }
    
    .select2-container .select2-selection--single {
        height: 42px;
        border-radius: var(--border-radius) !important;
        border: 1px solid #e0e0e0 !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
    
    /* Button Styles */
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 10px 25px;
        font-weight: 500;
        transition: var(--transition);
    }
    
    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        transform: translateY(-2px);
    }
    
    .btn-outline-secondary {
        transition: var(--transition);
    }
    
    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .sidebar-menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .sidebar-item {
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            border-left: none;
        }
    }
    
    @media (max-width: 768px) {
        .form-section .row > div {
            margin-bottom: 15px;
        }
        
        .form-section .row > div:last-child {
            margin-bottom: 0;
        }
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Category change event
    $('#category_id').change(function() {
        var category_id = $(this).val();
        if(category_id) {
            $.ajax({
                url: '/get-subcategories/' + category_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#subcategory_id').empty();
                    $('#subcategory_id').append('<option value="">Select Subcategory</option>');
                    $.each(data, function(key, value) {
                        $('#subcategory_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                    
                    // Clear child categories when category changes
                    $('#childcategory_id').empty();
                    $('#childcategory_id').append('<option value="">Select Child Category</option>');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#subcategory_id').empty();
            $('#subcategory_id').append('<option value="">Select Subcategory</option>');
            $('#childcategory_id').empty();
            $('#childcategory_id').append('<option value="">Select Child Category</option>');
        }
    });

    // Subcategory change event
    $('#subcategory_id').change(function() {
        var subcategory_id = $(this).val();
        if(subcategory_id) {
            $.ajax({
                url: '/get-childcategories/' + subcategory_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#childcategory_id').empty();
                    $('#childcategory_id').append('<option value="">Select Child Category</option>');
                    $.each(data, function(key, value) {
                        $('#childcategory_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#childcategory_id').empty();
            $('#childcategory_id').append('<option value="">Select Child Category</option>');
        }
    });
});




function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    const reader = new FileReader();
    
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        // Hide the placeholder
        input.parentElement.querySelector('.upload-placeholder').style.display = 'none';
    }
    
    if (file) {
        reader.readAsDataURL(file);
    }
}

// Country, State, City dynamic dropdowns
$(document).ready(function() {
    // Country change event
    $('#country_id').change(function() {
        var country_id = $(this).val();
        if(country_id) {
            $.ajax({
                url: '/get-states/' + country_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#state_id').empty();
                    $('#state_id').append('<option value="">Select State/Region</option>');
                    if(data.length > 0) {
                        $.each(data, function(key, value) {
                            $('#state_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    } else {
                        $('#state_id').append('<option value="">No states found</option>');
                    }
                    
                    // Clear cities when country changes
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select City</option>');
                },
                error: function(xhr, status, error) {
                    console.error("Error loading states: ", error);
                    $('#state_id').empty().append('<option value="">Error loading states</option>');
                    alert('Failed to load states. Please try again.');
                }
            });
        } else {
            $('#state_id').empty().append('<option value="">Select State/Region</option>');
            $('#city_id').empty().append('<option value="">Select City</option>');
        }
    });

    // State change event
    $('#state_id').change(function() {
        var state_id = $(this).val();
        if(state_id) {
            $.ajax({
                url: '/get-cities/' + state_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select City</option>');
                    $.each(data, function(key, value) {
                        $('#city_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error loading cities: ", error);
                    $('#city_id').empty().append('<option value="">Error loading cities</option>');
                }
            });
        } else {
            $('#city_id').empty().append('<option value="">Select City</option>');
        }
    });

    // Initialize with old values if form validation fails
    @if(old('country_id'))
        $('#country_id').val({{ old('country_id') }}).trigger('change');
        setTimeout(function() {
            $('#state_id').val({{ old('state_id') ?? 'null' }}).trigger('change');
            setTimeout(function() {
                $('#city_id').val({{ old('city_id') ?? 'null' }});
            }, 500);
        }, 500);
    @endif

    // Category change event
    $('#category_id').change(function() {
        var category_id = $(this).val();
        if(category_id) {
            $.ajax({
                url: '/get-subcategories/' + category_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#subcategory_id').empty();
                    $('#subcategory_id').append('<option value="">Select Subcategory</option>');
                    $.each(data, function(key, value) {
                        $('#subcategory_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                    
                    // Clear child categories when category changes
                    $('#childcategory_id').empty();
                    $('#childcategory_id').append('<option value="">Select Child Category</option>');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#subcategory_id').empty();
            $('#subcategory_id').append('<option value="">Select Subcategory</option>');
            $('#childcategory_id').empty();
            $('#childcategory_id').append('<option value="">Select Child Category</option>');
        }
    });

    // Subcategory change event
    $('#subcategory_id').change(function() {
        var subcategory_id = $(this).val();
        if(subcategory_id) {
            $.ajax({
                url: '/get-childcategories/' + subcategory_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#childcategory_id').empty();
                    $('#childcategory_id').append('<option value="">Select Child Category</option>');
                    $.each(data, function(key, value) {
                        $('#childcategory_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#childcategory_id').empty();
            $('#childcategory_id').append('<option value="">Select Child Category</option>');
        }
    });
});
</script>

<!-- Include necessary JS libraries -->
@endsection