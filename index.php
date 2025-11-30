<?php include("./config/dbConnection.php") ?>
<?php
  $his_numcard = null;
  if (isset($_GET["his_numcard"])) {
    $his_numcard = $_GET["his_numcard"];
  }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สถาบันรับรองพระเครื่องเมืองชลฯ - AMULET CERTIFICATION</title>
    <link rel="shortcut icon" type="image/x-icon" href="./assets/Logo.png">
    
    <!-- Modern CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.0/css/lightgallery-bundle.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Modern Styles -->
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #f59e0b;
            --accent-color: #10b981;
            --dark-color: #1f2937;
            --light-gray: #f8fafc;
            --border-color: #e5e7eb;
            --text-dark: #374151;
            --text-light: #6b7280;
            --success-color: #059669;
            --warning-color: #d97706;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Kanit', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* Header Styling */
        .main-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .header-title {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
            margin: 0;
        }

        @media (max-width: 768px) {
            .header-title {
                font-size: 1.8rem;
            }
        }

        /* Card Styling */
        .modern-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.3);
        }

        .card-header-modern {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="1000,100 1000,0 0,0"/></svg>');
            background-size: 100% 100%;
        }

        .card-header-modern h4 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .search-section {
            padding: 3rem;
        }

        .search-form {
            max-width: 500px;
            margin: 0 auto;
        }

        .form-floating label {
            color: var(--text-light);
            font-weight: 500;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
            background: white;
        }

        .btn-modern {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 15px;
            padding: 1rem 2.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
            color: white;
        }

        /* Result Card Styling */
        .result-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .result-header {
            background: linear-gradient(135deg, var(--success-color), var(--accent-color));
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .result-body {
            padding: 2rem;
        }

        .info-row {
            display: flex;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.3s ease;
        }

        .info-row:hover {
            background-color: var(--light-gray);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--text-dark);
            min-width: 150px;
            display: flex;
            align-items: center;
        }

        .info-label i {
            margin-right: 0.5rem;
            color: var(--primary-color);
            width: 20px;
        }

        .info-value {
            color: var(--text-light);
            flex: 1;
        }

        /* Gallery Styling */
        .gallery-section {
            margin-top: 2rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            padding: 1rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Badge Styling */
        .price-badge {
            background: linear-gradient(135deg, var(--warning-color), var(--secondary-color));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
            margin-top: 0.5rem;
        }

        .status-badge {
            background: linear-gradient(135deg, var(--success-color), var(--accent-color));
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .search-section {
                padding: 2rem 1rem;
            }
            
            .result-body {
                padding: 1rem;
            }
            
            .info-row {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .info-label {
                min-width: auto;
            }
            
            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-up {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <h1 class="header-title">
                    <i class="fas fa-certificate me-3"></i>
                    สถาบันรับรองพระเครื่องเมืองชลฯ
                </h1>
            </div>
        </div>
    </header>

    <?php if ($his_numcard): ?>
        <!-- Results Section -->
        <div class="container">
            <?php            
            $sql_history = $conn->prepare("SELECT * FROM tb_history where his_numcard = ?");
            $sql_history->execute([$his_numcard]);
            $result_history = $sql_history->fetchAll();
            
            if (count($result_history) > 0):
                foreach($result_history as $row_history):
            ?>
            <div class="result-card fade-in">
                <div class="result-header">
                    <h3><i class="fas fa-id-card me-2"></i><?php echo htmlspecialchars($row_history['his_numcard']); ?></h3>
                    <span class="status-badge"><i class="fas fa-check-circle me-1"></i>รับรองแล้ว</span>
                </div>
                
                <div class="result-body">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-tag"></i>ประเภท:
                        </div>
                        <div class="info-value"><?php echo htmlspecialchars($row_history['his_type']); ?></div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-gem"></i>ชื่อพระ:
                        </div>
                        <div class="info-value"><?php echo htmlspecialchars($row_history['his_nameproduct']); ?></div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i>จังหวัด:
                        </div>
                        <div class="info-value"><?php echo htmlspecialchars($row_history['his_province']); ?></div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-user"></i>เจ้าของพระ:
                        </div>
                        <div class="info-value"><?php echo htmlspecialchars($row_history['his_owner']); ?></div>
                    </div>
                    
                    <?php if (!empty($row_history['his_price'])): ?>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-money-bill-wave"></i>ราคาประเมิน:
                        </div>
                        <div class="info-value">
                            <span class="price-badge">
                                ฿<?php echo number_format($row_history['his_price'], 0); ?>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($row_history['his_tel'])): ?>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>เบอร์โทรศัพท์:
                        </div>
                        <div class="info-value">
                            <a href="tel:<?php echo $row_history['his_tel']; ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($row_history['his_tel']); ?>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-alt"></i>วันที่ออกบัตร:
                        </div>
                        <div class="info-value"><?php echo htmlspecialchars($row_history['his_datecard']); ?></div>
                    </div>
                    
                    <?php if (!empty($row_history['his_detailproduct'])): ?>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-info-circle"></i>รายละเอียด:
                        </div>
                        <div class="info-value"><?php echo nl2br(htmlspecialchars($row_history['his_detailproduct'])); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Gallery Section -->
            <div class="modern-card slide-up">
                <div class="card-header-modern">
                    <h4><i class="fas fa-images me-2"></i>ภาพประกอบการรับรอง</h4>
                </div>
                
                <div class="result-body">
                    <div id="lightgallery" class="gallery-grid">
                        <?php	
                        $sql_image = $conn->prepare("select * from tb_history 
                            left join tb_image on tb_image.his_code=tb_history.his_code 
                            where tb_history.his_numcard = ?
                            and tb_image.images != ''
                            and tb_image.image_sort between 1 and 9");
                        $sql_image->execute([$his_numcard]);
                        $result_image = $sql_image->fetchAll();
                        
                        if(count($result_image) > 0):
                            foreach($result_image as $row_image):
                                $images = 'a/page/add_card_image/upimg-port/'. $row_image['images'];
                        ?>
                        <div class="gallery-item" data-src="<?php echo $images; ?>">
                            <img src="<?php echo $images; ?>" alt="<?php echo htmlspecialchars($row_image['detail1']); ?>">
                            <div class="gallery-overlay">
                                <h6><?php echo htmlspecialchars($row_image['detail1']); ?></h6>
                                <p class="mb-0"><?php echo htmlspecialchars($row_image['detail3']); ?></p>
                            </div>
                        </div>
                        <?php 
                            endforeach;
                        else:
                        ?>
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted">ไม่มีรูปภาพประกอบ</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php else: ?>
            <div class="modern-card fade-in text-center">
                <div class="result-body py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4>ไม่พบข้อมูล</h4>
                    <p class="text-muted">ไม่พบหมายเลขบัตร "<?php echo htmlspecialchars($his_numcard); ?>" ในระบบ</p>
                </div>
            </div>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="./" class="btn-modern">
                    <i class="fas fa-search me-2"></i>ค้นหาหมายเลขบัตรอื่น
                </a>
            </div>
        </div>

    <?php else: ?>
        <!-- Search Section -->
        <div class="container">
            <div class="modern-card fade-in">
                <div class="card-header-modern">
                    <h4><i class="fas fa-search me-2"></i>ตรวจสอบใบรับรองพระเครื่อง</h4>
                </div>
                
                <div class="search-section">
                    <p class="text-center text-muted mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        สำหรับบัตรที่ไม่มี QR Code กรุณากรอกหมายเลขบัตรเพื่อตรวจสอบ
                    </p>
                    
                    <form class="search-form" id="searchForm">
                        <div class="form-floating mb-4">
                            <input type="text" 
                                   class="form-control" 
                                   id="numcard" 
                                   name="numcard" 
                                   placeholder="กรอกเลขที่บัตร..."
                                   required autocomplete="off">
                            <label for="numcard">
                                <i class="fas fa-id-card me-2"></i>เลขที่บัตร
                            </label>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn-modern" id="searchBtn">
                                <span class="btn-text">
                                    <i class="fas fa-search me-2"></i>ตรวจสอบ
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <br><br>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.0/lightgallery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.0/plugins/thumbnail/lg-thumbnail.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.0/plugins/zoom/lg-zoom.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize LightGallery
            const gallery = document.getElementById('lightgallery');
            if (gallery) {
                lightGallery(gallery, {
                    plugins: [lgThumbnail, lgZoom],
                    speed: 500,
                    thumbnail: true,
                    download: false
                });
            }

            // Search form handling
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                
                const numcard = $('#numcard').val().trim();
                if (!numcard) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณากรอกเลขที่บัตร',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return;
                }

                // Show loading state
                const searchBtn = $('#searchBtn');
                const originalText = searchBtn.find('.btn-text').html();
                searchBtn.find('.btn-text').html('<span class="loading-spinner"></span>กำลังค้นหา...');
                searchBtn.prop('disabled', true);

                $.ajax({
                    url: "controllers/chknumcard.php",
                    type: "POST",
                    data: { numcard: numcard },
                    success: function(response) {
                        const result = JSON.parse(response);
                        
                        if (result.statusCode == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'ค้นหาสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = `index.php?his_numcard=${numcard}`;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ไม่พบข้อมูล',
                                text: 'ไม่พบหมายเลขบัตรที่ค้นหาในระบบ',
                                confirmButtonColor: '#2563eb'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                            confirmButtonColor: '#2563eb'
                        });
                    },
                    complete: function() {
                        // Restore button state
                        searchBtn.find('.btn-text').html(originalText);
                        searchBtn.prop('disabled', false);
                        $('#numcard').focus();
                    }
                });
            });

            // Auto focus on load
            $('#numcard').focus();

            // Enter key handling
            $('#numcard').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#searchForm').submit();
                }
            });
        });
    </script>
</body>
</html>