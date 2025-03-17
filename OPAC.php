<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البحث حسب العنوان</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            margin-top: 20px;
        }
        form {
            margin-bottom: 20px;
            direction: rtl; /* لجعل النص من اليمين لليسار */
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
            text-align: right; /* لجعل النص داخل الحقل من اليمين */
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            direction: rtl; /* لجعل الجدول من اليمين لليسار */
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
            direction: rtl; /* لجعل أزرار التنقل من اليمين لليسار */
        }
        .pagination a {
            text-decoration: none;
            padding: 10px 15px;
            color: #007BFF;
            border: 1px solid #007BFF;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .pagination a:hover {
            background-color: #007BFF;
            color: white;
        }
        .pagination a.disabled {
            color: #ccc;
            border-color: #ccc;
        }
        .logo {
            margin: 20px auto;
        }
        /* إضافة CSS لتفاصيل الكتاب */
        .book-details {
        background-color: #f8f9fa; /* لون خلفية فاتح */
        border: 1px solid #ddd; /* إطار خفيف حول التفاصيل */
        padding: 20px;
        border-radius: 10px; /* حواف مستديرة */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* ظل لإضافة عمق */
        max-width: 500px;
        margin: 20px auto; /* توسيط البطاقة */
    }

    /* تحسين العنوان */
    .book-details h3 {
        text-align: center; /* توسيط العنوان */
        color: #333;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* تحسين الفقرات */
    .book-details p {
        font-size: 18px;
        line-height: 1.6;
        color: #555;
    }

    /* تمييز القيم */
    .detail-value {
        color: #007bff; /* لون أزرق مميز */
        font-weight: bold;
    }

    /* تأثير تحريك على الفقرة */
    .book-details p {
        transition: all 0.3s ease;
    }

    /* تأثير عند تمرير الفأرة */
    .book-details p:hover {
        transform: translateX(10px); /* تحريك النص قليلاً عند التمرير */
    }
    </style>
    <script>
        function showBookDetails(titre,Titrecomple, isbn, nomVedette, TEDITION,lieuEdition, cote, annee,DKEY,D_RESUME) {
    // إعداد تفاصيل الكتاب
    var details = `
        <div id="book-details" class="book-details">
    <h3>تفاصيل الكتاب</h3>
    <p><strong>العنوان:</strong> <span class="detail-value">${titre}</span></p>
    <p><strong>عنوان متمم:</strong> <span class="detail-value">${Titrecomple}</span></p>
    <p><strong>ر.د.م.ك:</strong> <span class="detail-value">${isbn}</span></p>
    <p><strong>اسم المؤلف:</strong> <span class="detail-value">${nomVedette}</span></p>
     <p><strong>الطبعة:</strong> <span class="detail-value">${TEDITION}</span></p>
    <p><strong>مكان النشر:</strong> <span class="detail-value">${lieuEdition}</span></p>
    <p><strong>الكود:</strong> <span class="detail-value">${cote}</span></p>
    <p><strong>السنة:</strong> <span class="detail-value">${annee}</span></p>
    <p><strong>كلمات مفتاحية:</strong> <span class="detail-value">${DKEY}</span></p>
    <p><strong>تلخيص:</strong> <span class="detail-value">${D_RESUME}</span></p>
    
</div>
    `;

    // عرض التفاصيل
    document.getElementById('book-details').innerHTML = details;
    document.getElementById('book-details').style.display = 'block'; // إظهار التفاصيل
}

    </script>
</head>
<body>

    <!-- إضافة الصورة -->
    <img src="bplp.png" alt="Logo" class="logo" width="400" height="400">

    <!-- نموذج البحث -->
    <form method="GET" action="">
        <input type="text" name="recherche" placeholder="البحث حسب الاختيار" value="<?php echo isset($_GET['titre']) ? htmlspecialchars($_GET['titre']) : ''; ?>">
        <button type="submit">بحث</button>
    </form>

    <?php
    // معلمات الاتصال بقاعدة البيانات
    $serverName = "DESKTOP-JGFU26C"; // استبدل باسم الخادم الخاص بك
    $connectionOptions = array(
        "Database" => "syngeb", // استبدل باسم قاعدة البيانات الخاصة بك
        "Uid" => "sa", // اسم المستخدم
        "PWD" => "Aa123456*", // كلمة المرور
        "CharacterSet" => "UTF-8"
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    // التحقق من الاتصال
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // جلب إدخال البحث
    $searchTitre = isset($_GET['recherche']) ? $_GET['recherche'] : '';

    // متغيرات الصفحات
    $resultsPerPage = 8;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $resultsPerPage;

    if ($searchTitre !== '') {
        // إذا أدخل المستخدم '*', قم بجلب جميع النتائج
        if ($searchTitre === '*') {
            $countSql = "SELECT COUNT(*) AS total
                         FROM dbo.NOTICE AS N
                         INNER JOIN dbo.NOTICE_AUTEUR AS NA ON N.DOC_ID = NA.DOC_ID
                         INNER JOIN dbo.VEDETTE AS V ON NA.VED_ID = V.VED_ID    ";
           $countStmt = sqlsrv_query($conn, $countSql);
            $rowCount = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);
            $totalResults = $rowCount['total'];
            $totalPages = ceil($totalResults / $resultsPerPage);

            $sql = "SELECT 
                    ISNULL(N.DOC_TITRE_PROPRE, '') AS Titre,
                    ISNULL(N.DOC_TITRE_COMPLEMENT, '') AS Titrecomple,
                    ISNULL(N.DOC_TITRE_PARALLELE, '') AS TITRE_PARALLE,
                    ISNULL(N.DOC_TITRE_ENSEMBLE, '') AS TITRE_ENSEMBLE,
                    ISNULL(N.DOC_NUMERO_PARTIE, '') AS NUMERO_PARTIE,
                    ISNULL(V.VED_NOM, '') AS NomVedette,
                    ISNULL(N.DOC_LIEU_EDITION, '') AS LIEU_EDITION,
                    ISNULL(N.DOC_LIEU_EDITION2, '') AS LIEU_EDITION2,
                    ISNULL(N.COT_NOTICE, '') AS Cote,
                    ISNULL(TD.TYP_LIBELLE, '') AS TypeLibelle,
                    ISNULL(N.DOC_EDITION, '') AS TEDITION,
                    ISNULL(N.DOC_ANNEE, '') AS Annee,
                    ISNULL(N.DOC_LIEU_SOUTENANCE, '') AS LIEU_SOUTENANCE,
                    ISNULL(N.COL_NUMERO, '') AS C_NUMERO,
                    ISNULL(N.SCL_NUMERO, '') AS scl_NUMERO,
                    ISNULL(N.DOC_NBR_UNITE, '') AS NBR_UNITE,
                    ISNULL(N.DOC_ILLUSTRATION, '') AS ILLUSTRATION,
                    ISNULL(N.DOC_FORMAT, '') AS C_FORMAT,                     
                    ISNULL(N.DOC_KEYWORDS, '') AS DKEY,
                    ISNULL(N.DOC_MATERIEL, '') AS MATERIEL,
                    ISNULL(N.DOC_MATHEMATIQUE, '') AS MATHEMATIQUE,
                    ISNULL(N.DON_ECHELLE, '') AS ECHELLE,
                    ISNULL(N.DON_PROJECTION, '') AS D_PROJECTION,
                    ISNULL(N.DON_COORDONNEES, '') AS COORDONNEES,
                    ISNULL(N.DON_MENTION, '') AS MENTION,
                    ISNULL(N.DON_EQUINOXE, '') AS EQUINOXE,
                    ISNULL(N.DOC_NUMEROTATION, '') AS D_NUMEROTATION,
                    ISNULL(N.DOC_MUSIQUE, '') AS D_MUSIQUE,
                    ISNULL(N.DOC_RESSOURCE, '') AS D_RESSOURCE,
                    ISNULL(N.DOC_ISBN, '') AS ISBN,
                    ISNULL(N.DOC_ISSN, '') AS ISSN,
                    ISNULL(N.DOC_NUM, '') AS D_NUM,
                    ISNULL(N.DOC_NOTE, '') AS D_NOTE,
                    ISNULL(N.DOC_RESUME, '') AS D_RESUME,
                    ISNULL(N.DOC_NBR_EXEMPLAIRE, '') AS D_EXEMPLAIRE
                FROM dbo.NOTICE AS N
                INNER JOIN dbo.NOTICE_AUTEUR AS NA ON N.DOC_ID = NA.DOC_ID
                INNER JOIN dbo.VEDETTE AS V ON NA.VED_ID = V.VED_ID
                INNER JOIN dbo.TYPE_DOCUMENT AS TD ON TD.TYP_ID = N.TYP_ID
                  
                    ORDER BY N.DOC_ID
                    OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
          $params = array( $offset, $resultsPerPage);
        } else {
            // جلب النتائج المفلترة
            $countSql = "SELECT COUNT(*) AS total
                         FROM dbo.NOTICE AS N
                         INNER JOIN dbo.NOTICE_AUTEUR AS NA ON N.DOC_ID = NA.DOC_ID
                         INNER JOIN dbo.VEDETTE AS V ON NA.VED_ID = V.VED_ID
                         WHERE REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(N.DOC_TITRE_PROPRE, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') LIKE '%' + REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(?, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') + '%'
                         OR REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(N.DOC_ISBN, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') LIKE '%' + REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(?, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') + '%'
                         OR REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(V.VED_NOM, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') LIKE '%' + REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(?, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') + '%'";
            $countStmt = sqlsrv_query($conn, $countSql, array($searchTitre, $searchTitre, $searchTitre));
            $rowCount = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);
            $totalResults = $rowCount['total'];
            $totalPages = ceil($totalResults / $resultsPerPage);

            $sql = "SELECT 
                    ISNULL(N.DOC_TITRE_PROPRE, '') AS Titre,
                    ISNULL(N.DOC_TITRE_COMPLEMENT, '') AS Titrecomple,
                    ISNULL(N.DOC_TITRE_PARALLELE, '') AS TITRE_PARALLE,
                    ISNULL(N.DOC_TITRE_ENSEMBLE, '') AS TITRE_ENSEMBLE,
                    ISNULL(N.DOC_NUMERO_PARTIE, '') AS NUMERO_PARTIE,
                    ISNULL(V.VED_NOM, '') AS NomVedette,
                    ISNULL(N.DOC_LIEU_EDITION, '') AS LIEU_EDITION,
                    ISNULL(N.DOC_LIEU_EDITION2, '') AS LIEU_EDITION2,
                    ISNULL(N.COT_NOTICE, '') AS Cote,
                    ISNULL(TD.TYP_LIBELLE, '') AS TypeLibelle,
                    ISNULL(N.DOC_EDITION, '') AS TEDITION,
                    ISNULL(N.DOC_ANNEE, '') AS Annee,
                    ISNULL(N.DOC_LIEU_SOUTENANCE, '') AS LIEU_SOUTENANCE,
                    ISNULL(N.COL_NUMERO, '') AS C_NUMERO,
                    ISNULL(N.SCL_NUMERO, '') AS scl_NUMERO,
                    ISNULL(N.DOC_NBR_UNITE, '') AS NBR_UNITE,
                    ISNULL(N.DOC_ILLUSTRATION, '') AS ILLUSTRATION,
                    ISNULL(N.DOC_FORMAT, '') AS C_FORMAT,
                    ISNULL(N.DOC_KEYWORDS, '') AS DKEY,
                    ISNULL(N.DOC_MATERIEL, '') AS MATERIEL,
                    ISNULL(N.DOC_MATHEMATIQUE, '') AS MATHEMATIQUE,
                    ISNULL(N.DON_ECHELLE, '') AS ECHELLE,
                    ISNULL(N.DON_PROJECTION, '') AS D_PROJECTION,
                    ISNULL(N.DON_COORDONNEES, '') AS COORDONNEES,
                    ISNULL(N.DON_MENTION, '') AS MENTION,
                    ISNULL(N.DON_EQUINOXE, '') AS EQUINOXE,
                    ISNULL(N.DOC_NUMEROTATION, '') AS D_NUMEROTATION,
                    ISNULL(N.DOC_MUSIQUE, '') AS D_MUSIQUE,
                    ISNULL(N.DOC_RESSOURCE, '') AS D_RESSOURCE,
                    ISNULL(N.DOC_ISBN, '') AS ISBN,
                    ISNULL(N.DOC_ISSN, '') AS ISSN,
                    ISNULL(N.DOC_NUM, '') AS D_NUM,
                    ISNULL(N.DOC_NOTE, '') AS D_NOTE,
                    ISNULL(N.DOC_RESUME, '') AS D_RESUME,
                    ISNULL(N.DOC_NBR_EXEMPLAIRE, '') AS D_EXEMPLAIRE
                FROM dbo.NOTICE AS N
                INNER JOIN dbo.NOTICE_AUTEUR AS NA ON N.DOC_ID = NA.DOC_ID
                INNER JOIN dbo.VEDETTE AS V ON NA.VED_ID = V.VED_ID
                INNER JOIN dbo.TYPE_DOCUMENT AS TD ON TD.TYP_ID = N.TYP_ID
                    WHERE REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(N.DOC_TITRE_PROPRE, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') LIKE '%' + REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(?, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') + '%'
                         OR REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(N.DOC_ISBN, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') LIKE '%' + REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(?, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') + '%'
                         OR REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(V.VED_NOM, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') LIKE '%' + REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(?, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') + '%'
                  OR REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(N.DOC_KEYWORDS, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') LIKE '%' + REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(?, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') + '%'
                   OR REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(N.COT_NOTICE, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') LIKE '%' + REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(?, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ى', 'ي'), 'ئ', 'ي'), 'ة', 'ه'), 'ؤ', 'و') + '%'
                    ORDER BY N.DOC_ID
                    OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
            $params = array($searchTitre, $searchTitre, $searchTitre,$searchTitre,$searchTitre, $offset, $resultsPerPage);
        }

        // تنفيذ الاستعلام
        $stmt = sqlsrv_query($conn, $sql, $params);

        // عرض النتائج في جدول
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo "<table>";
        echo "<tr><th>ISBN</th><th>العنوان</th><th>اسم المؤلف</th><th>مكان النشر</th><th>الكود</th><th>السنة</th><th>انتقل</th></tr>";
        
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['ISBN']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Titre']) . "</td>";
            echo "<td>" . htmlspecialchars($row['NomVedette']) . "</td>";
            echo "<td>" . htmlspecialchars($row['LIEU_EDITION']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Cote']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Annee']) . "</td>";
            
            echo '<td><button type="button" onclick="showBookDetails(\'' . addslashes($row['Titre']) . '\', \'' . addslashes($row['Titrecomple']) . '\', \'' . addslashes($row['ISBN']) . '\', \'' . addslashes($row['NomVedette']) . '\', \'' . addslashes($row['TEDITION']) . '\' ,\'' . addslashes($row['LIEU_EDITION']) . '\', \'' . addslashes($row['Cote']) . '\', \'' . addslashes($row['Annee']) . '\',\'' . addslashes($row['DKEY']) . '\', \'' . addslashes($row['D_RESUME']) . '\')">تفاصيل</button></td>';
            echo "</tr>";
        }
        echo "</table>";


       
echo '<div class="pagination">';

// زر "السابق"
if ($page > 1) {
    echo '<a href="?recherche=' . htmlspecialchars($searchTitre) . '&page=' . ($page - 1) . '">السابق</a>';
} else {
    echo '<a class="disabled">السابق</a>';
}

// عرض الصفحات
if ($totalPages <= 6) {
    // إذا كانت الصفحات أقل أو تساوي 6، عرض كل الصفحات
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo '<a class="disabled">' . $i . '</a>';
        } else {
            echo '<a href="?recherche=' . htmlspecialchars($searchTitre) . '&page=' . $i . '">' . $i . '</a>';
        }
    }
} else {
    // إذا كانت الصفحة الحالية أكبر من 3، عرض الصفحة السابقة
    if ($page > 3) {
        echo '<a href="?recherche=' . htmlspecialchars($searchTitre) . '&page=1">1</a>';
       
        echo '<span>...</span>'; // نقاط

        // عرض الصفحة التي تسبق الحالية
        echo '<a href="?recherche=' . htmlspecialchars($searchTitre) . '&page=' . ($page - 1) . '">' . ($page - 1) . '</a>';
    } 

    // عرض الصفحة الحالية
    echo '<a class="disabled">' . $page . '</a>';

    // عرض الصفحة التي تلي الحالية
    if ($page < $totalPages - 1) {
        echo '<a href="?recherche=' . htmlspecialchars($searchTitre) . '&page=' . ($page + 1) . '">' . ($page + 1) . '</a>';
        echo '<span>...</span>'; // نقاط
    }
    
    // عرض الصفحة الأخيرة
    echo '<a href="?recherche=' . htmlspecialchars($searchTitre) . '&page=' . $totalPages . '">' . $totalPages . '</a>';
}

// زر "التالي"
if ($page < $totalPages) {
    echo '<a href="?recherche=' . htmlspecialchars($searchTitre) . '&page=' . ($page + 1) . '">التالي</a>';
} else {
    echo '<a class="disabled">التالي</a>';
}
echo '</div>';

    }
    echo '<div id="book-details" class="book-details"></div>';
        // إغلاق الاتصال بقاعدة البيانات
        sqlsrv_close($conn);
        ?>
</body>
</html>