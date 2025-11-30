<?php include("./config/dbConnection.php") ?>
<?php
  $his_numcard = null;
  if (isset($_GET["his_numcard"])) {
    $his_numcard = $_GET["his_numcard"];
  }
?>

<?php
// Security headers - แก้ไข CSP ให้รองรับ Font Awesome
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
// แก้ไข CSP ให้รองรับ Font Awesome และ fonts
header('Content-Security-Policy: default-src \'self\' https:; script-src \'self\' \'unsafe-inline\' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; style-src \'self\' \'unsafe-inline\' https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com; font-src \'self\' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src \'self\' data: https:;');

// Rate limiting (simple implementation)
session_start();
if (!isset($_SESSION['search_count'])) {
    $_SESSION['search_count'] = 0;
    $_SESSION['search_time'] = time();
}

if ($_SESSION['search_count'] > 10 && (time() - $_SESSION['search_time']) < 300) {
    http_response_code(429);
    die('Too many requests. Please try again later.');
}

// Simple file-based caching
function getCachedResult($key, $ttl = 300) {
    $cacheFile = "cache/" . md5($key) . ".cache";
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
        return json_decode(file_get_contents($cacheFile), true);
    }
    return false;
}

function setCachedResult($key, $data) {
    if (!is_dir("cache")) mkdir("cache", 0755, true);
    $cacheFile = "cache/" . md5($key) . ".cache";
    file_put_contents($cacheFile, json_encode($data));
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
    
    <!-- Font Awesome - เพิ่ม fallback และ integrity -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" 
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
          crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- Fallback สำหรับ Font Awesome หากไม่สามารถโหลดจาก CDN ได้ -->
    <script>
        // ตรวจสอบว่า Font Awesome โหลดสำเร็จหรือไม่
        document.addEventListener('DOMContentLoaded', function() {
            var testElement = document.createElement('i');
            testElement.className = 'fas fa-home';
            testElement.style.position = 'absolute';
            testElement.style.left = '-9999px';
            document.body.appendChild(testElement);
            
            var computedStyle = window.getComputedStyle(testElement, '::before');
            var content = computedStyle.getPropertyValue('content');
            
            // หาก Font Awesome ไม่โหลด ให้ใช้ fallback
            if (content === 'none' || content === '') {
                var fallbackLink = document.createElement('link');
                fallbackLink.rel = 'stylesheet';
                fallbackLink.href = 'https://use.fontawesome.com/releases/v6.4.0/css/all.css';
                document.head.appendChild(fallbackLink);
            }
            
            document.body.removeChild(testElement);
        });
    </script>
    
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

        /* เพิ่ม CSS สำรอง สำหรับ icons หากไม่โหลด */
        .icon-fallback::before {
            content: "•";
            color: var(--primary-color);
            font-weight: bold;
            margin-right: 0.5rem;
        }
        
        /* Ensure icons are visible */
        i[class*="fa"] {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brand", sans-serif !important;
            font-weight: 900;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Force display of icons for desktop */
        @media (min-width: 768px) {
            i[class*="fa"] {
                display: inline-block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
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
        
        /* แก้ปัญหา text gradient ใน desktop */
        @media (min-width: 768px) {
            .header-title {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                /* Fallback สำหรับ browser ที่ไม่รองรับ */
                color: var(--primary-color);
            }
            
            /* Support for older browsers */
            @supports not (-webkit-background-clip: text) {
                .header-title {
                    color: var(--primary-color);
                }
            }
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
            text-align: center;
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

        /* Loading skeleton animation */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .skeleton-card {
            height: 200px;
            border-radius: 15px;
            margin-bottom: 1rem;
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

            /* Better mobile touch targets */
            .btn-modern {
                min-height: 48px;
                font-size: 1.2rem;
            }
            
            .form-control {
                min-height: 48px;
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            .gallery-item {
                margin-bottom: 1rem;
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

    <!-- SEO Meta Tags -->
    <meta name="description" content="ตรวจสอบใบรับรองพระเครื่องออนไลน์ สถาบันรับรองพระเครื่องเมืองชลบุรี ตรวจสอบความถูกต้องของพระเครื่อง">
    <meta name="keywords" content="พระเครื่อง, ใบรับรอง, ตรวจสอบ, ชลบุรี, สถาบันรับรอง">
    <meta property="og:title" content="สถาบันรับรองพระเครื่องเมืองชลฯ">
    <meta property="og:description" content="ตรวจสอบใบรับรองพระเครื่องออนไลน์">
    <meta property="og:type" content="website">

    <!-- Preload critical resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" as="style">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <!-- Add to <head> for PWA support -->
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#2563eb">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="apple-touch-icon" href="icons/icon-192x192.png">
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
            // ปรับปรุง query สำหรับประสิทธิภาพ
            try {
                // Add index hints and optimize joins
                $sql_history = $conn->prepare("
                    SELECT h.*, m.member_name 
                    FROM tb_history h 
                    LEFT JOIN tb_member m ON h.his_create_by = m.member_id 
                    WHERE h.his_numcard = ? 
                    LIMIT 1
                ");
                $sql_history->execute([$his_numcard]);
                $result_history = $sql_history->fetchAll(PDO::FETCH_ASSOC);
                
                // Optimize image query
                $sql_image = $conn->prepare("
                    SELECT i.images, i.detail1, i.detail2, i.detail3, i.image_sort 
                    FROM tb_image i 
                    WHERE i.his_code = (
                        SELECT his_code FROM tb_history WHERE his_numcard = ? LIMIT 1
                    ) 
                    AND i.images IS NOT NULL 
                    AND i.images != '' 
                    AND i.image_sort BETWEEN 1 AND 9 
                    ORDER BY i.image_sort ASC
                ");
                $sql_image->execute([$his_numcard]);
                $result_image = $sql_image->fetchAll(PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                // Show user-friendly error message
            }
            
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
                    
                    <!-- เพิ่ม ARIA labels และ semantic HTML -->
                    <main role="main" aria-label="ตรวจสอบใบรับรองพระเครื่อง">
                        <form class="search-form" id="searchForm" role="search" aria-label="ค้นหาใบรับรอง">
                            <div class="form-floating mb-4">
                                <input type="text" 
                                       class="form-control" 
                                       id="numcard" 
                                       name="numcard" 
                                       placeholder="กรอกเลขที่บัตร..."
                                       required 
                                       autocomplete="off"
                                       aria-describedby="numcard-help"
                                       pattern="[A-Za-z0-9]+"
                                       maxlength="20">
                                <label for="numcard">
                                    <i class="fas fa-id-card me-2" aria-hidden="true"></i>เลขที่บัตร
                                </label>
                            </div>
                            <div id="numcard-help" class="visually-hidden">
                                กรอกหมายเลขบัตรรับรองพระเครื่อง เช่น CCA23071501
                            </div>
                            
                            <!-- เพิ่มปุ่มยืนยันที่นี่ -->
                            <div class="text-center">
                                <button type="submit" class="btn-modern" id="searchBtn">
                                    <span class="btn-text">
                                        <i class="fas fa-search me-2"></i>ตรวจสอบ
                                    </span>
                                </button>
                            </div>
                        </form>
                    </main>
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

            // Add search analytics
            function trackSearch(numcard, found) {
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'search', {
                        'search_term': numcard,
                        'result_found': found
                    });
                }
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
                    timeout: 10000, // 10 second timeout
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            
                            if (result.statusCode == 200) {
                                // Track search event
                                trackSearch(numcard, true);
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ค้นหาสำเร็จ',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.href = `index.php?his_numcard=${numcard}`;
                                });
                            } else {
                                // Track search event for not found
                                trackSearch(numcard, false);
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ไม่พบข้อมูล',
                                    text: 'ไม่พบหมายเลขบัตรที่ค้นหาในระบบ',
                                    confirmButtonColor: '#2563eb'
                                });
                            }
                        } catch (e) {
                            console.error('JSON parse error:', e);
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ข้อมูลที่ได้รับจากเซิร์ฟเวอร์ไม่ถูกต้อง'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้';
                        if (status === 'timeout') {
                            errorMessage = 'การเชื่อมต่อใช้เวลานานเกินไป กรุณาลองใหม่อีกครั้ง';
                        } else if (xhr.status === 429) {
                            errorMessage = 'คำขอมากเกินไป กรุณารอสักครู่แล้วลองใหม่';
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: errorMessage,
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

            // Better input validation
            $('#numcard').on('input', function() {
                let value = $(this).val().toUpperCase();
                // Remove invalid characters
                value = value.replace(/[^A-Z0-9]/g, '');
                $(this).val(value);
                
                // Show format hint
                if (value.length > 0 && !/^CCA\d{8}$/.test(value) && value.length >= 11) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
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
    
    <!-- เพิ่ม Debug script สำหรับตรวจสอบ Font Awesome -->
    <script>
        console.log('Font Awesome Debug:', {
            userAgent: navigator.userAgent,
            isMobile: /iPhone|iPad|iPod|Android/i.test(navigator.userAgent),
            viewport: {
                width: window.innerWidth,
                height: window.innerHeight
            }
        });
    </script>
</body>
</html>