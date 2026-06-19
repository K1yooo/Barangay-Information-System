<?php
include 'database.php';

$news = [];
$result = mysqli_query($con, "SELECT * FROM news");
while ($row = mysqli_fetch_assoc($result)) {
    $news[] = $row;
}

$gallery = [];
$result = mysqli_query($con, "SELECT * FROM gallery");
while ($row = mysqli_fetch_assoc($result)) {
    $gallery[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['title'], $_POST['content'], $_POST['link'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $link = $_POST['link'];

        if (isset($_FILES['newsimage']['tmp_name']) && $_FILES['newsimage']['error'] === UPLOAD_ERR_OK) {
            $image = file_get_contents($_FILES['newsimage']['tmp_name']);
            $stmt = $con->prepare("INSERT INTO news (title, content, link, newsimage) VALUES (?, ?, ?, ?)");
            $null = NULL;
            $stmt->bind_param("sssb", $title, $content, $link, $null);
            $stmt->send_long_data(3, $image);
        } else {
            $stmt = $con->prepare("INSERT INTO news (title, content, link) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $content, $link);
        }

        if ($stmt->execute()) {
            echo "<script>alert('New news added successfully'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php';</script>";
        }
        $stmt->close();
    } elseif (isset($_POST['description'])) {
        $description = $_POST['description'];

        if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
            $stmt = $con->prepare("INSERT INTO gallery (image, description) VALUES (?, ?)");
            $stmt->bind_param("sb", $image, $description);

        if ($stmt->execute()) {
            echo "<script>alert('New gallery item added successfully'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php';</script>";
        }
        $stmt->close();
    }

    $con->close();
}
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/BrgyMalinao/Backend/CSS/webSettings.css"> 
</head>
<body>

    <div id="newsSettingModal1" class="modal11">
        <div class="modal-content11">
            <div class="col">
                <div class="bg11">
                    <span class="txt11">Web <br> Settings</span>
                </div>
            </div>
            <div class="col">
                <span class="close-btn11" onclick="closeModal('newsSettingModal1')">&times;</span>
                <button class="button11" onclick="openModal7('postModal')">Post</button>
                <div class="Scrollable-table11">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="newsTableBody">
                        <?php foreach ($news as $new): ?>
                                <tr>
                                    <td><?php echo isset($new['title']) ? $new['title'] : ''; ?></td>
                                    <td><?php echo isset($new['content']) ? $new['content'] : ''; ?></td>
                                    <td>
                                        <button class="button-red11" onclick="deleteNews(<?php echo $new['news_id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>    
                </div>
                <div class="col">
                <button class="button12" onclick="openModal7('postGalleryModal')">Gallery</button>
                <div class="Scrollable-table12">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="galleryTableBody">
                        <?php foreach ($gallery as $item): ?>
                                <tr>
                                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode(isset($item['image']) ? $item['image'] : ''); ?>" alt="Gallery Image" width="100"></td>
                                    <td><?php echo isset($item['description']) ? $item['description'] : ''; ?></td>
                                    <td>
                                        <button class="button-blue11" onclick="openUpdateModalForGallery(
                                            '<?php echo $item['gal_id']; ?>',
                                            '<?php echo $item['description']; ?>'
                                        )">Update</button>
                                        <button class="button-red11" onclick="deleteGallery(<?php echo $item['gal_id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>

    <div id="postModal" class="modal12">
    <div class="modal-content12">
        <div class="col">
            <div class="bg12">
                <span class="txt12">Add News</span>
            </div>
        </div>
        <div class="col">
            <span class="close-btn12" onclick="closeModal('postModal')">&times;</span>
            <form id="addNewsForm" action="newsModal.php" method="post" enctype="multipart/form-data">
                <div class="MoveAdd">
                    <div class="row1">
                        <div class="form-group">
                            <label for="add-title">Title:</label> <br>
                            <input type="text" id="add-title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="add-image">Image:</label><br>
                            <input type="file" id="add-image" name="newsimage">
                        </div>
                        
                    </div>

                    <div class="row1">
                        <div class="form-group">
                            <label for="add-content">Content:</label><br>
                            <textarea id="add-content" name="content" rows="4" placeholder="Type here..." required></textarea>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="form-group">
                            <label for="add-link">Link:</label><br>
                            <input type="text" id="add-link" name="link" required>
                        </div>
                    </div>

                    <div class="action-buttons1">
                        <button type="button" class="cancel-button" onclick="closeModal('postModal')">Cancel</button>
                        <input type="reset" value="Clear" class="button">
                        <input type="submit" value="Add" class="button">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="postGalleryModal" class="modal12">
    <div class="modal-content12">
        <div class="col">
            <div class="bg12">
                <span class="txt12">Add to Gallery</span>
            </div>
        </div>
        <div class="col">
            <span class="close-btn12" onclick="closeModal('postGalleryModal')">&times;</span>
            <form id="addGalleryForm" action="newsModal.php" method="post" enctype="multipart/form-data">
                <div class="MoveAdd">
                    <div class="row1">
                        <div class="form-group">
                            <label for="gallery-image">Image:</label><br>
                            <input type="file" id="gallery-image" name="image" required>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="form-group">
                            <label for="gallery-description">Description:</label><br>
                            <textarea id="gallery-description" name="description" rows="4" placeholder="Type here..." required></textarea>
                        </div>
                    </div>
                    <div class="action-buttons1">
                        <button type="button" class="cancel-button" onclick="closeModal('postGalleryModal')">Cancel</button>
                        <input type="reset" value="Clear" class="button">
                        <input type="submit" value="Add to Gallery" class="button">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


    <div id="UpdateNews">
            <div class="modal-content20">
            <div class="col">
                <div class="bg20">
                    <span class="txt20">Update News</span>
                </div>
            </div>
            <div class="col">
                <span class="close-btn20" onclick="closeModal('UpdateNews')">&times;</span>
                <form id="newsForm1" action="newsModal.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="update-newsid" name="news_id">
                    <div class="MoveUpt">
                        <div class="row1">
                            <div class="form-group">
                                <label for="update-title">Title:</label> <br>
                                <input type="text" id="update-title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="update-image">Image:</label><br>
                                <input type="file" id="update-image" name="image">
                            </div>
                        </div>
                        <div class="row1">
                            <div class="form-group">
                                <label for="update-content">Content:</label><br>
                                <textarea id="update-content" name="content" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="row1">
                            <div class="form-group">
                                <label for="update-link">Link:</label><br>
                                <input type="text" id="update-link" name="link" required>
                            </div>
                        </div>
                        <div class="action-buttons1">
                            <button type="button" class="cancel-button" onclick="closeModal('UpdateNews')">Cancel</button>
                            <input type="reset" value="Clear" class="button">
                            <input type="submit" value="Update" class="button">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="updateGalleryModal" class="modal21">
        <div class="modal-content21">
            <div class="col">
                <div class="bg21">
                    <span class="txt21">Update Gallery</span>
                </div>
            </div>
            <div class="col">
                <span class="close-btn21" onclick="closeModal('updateGalleryModal')">&times;</span>
                <form id="galleryForm1" method="post" enctype="multipart/form-data">>
                    <input type="hidden" id="update-gallery-id" name="gallery_id">
                    <div class="MoveUpt">
                        <div class="row21">
                            <div class="form-group">
                                <label for="update-gallery-description">Description:</label> <br>
                                <textarea id="update-gallery-description" name="description" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="row21">
                            <div class="form-group">
                                <label for="update-gallery-image">Image:</label><br>
                                <input type="file" id="update-gallery-image" name="image">
                            </div>
                        </div>
                        <div class="action-buttons1">
                            <button type="button" class="cancel-button" onclick="closeModal('updateGalleryModal')">Cancel</button>
                            <input type="reset" value="Clear" class="button">
                            <input type="submit" value="Update" class="button">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


 <?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['gallery_id']) && isset($_POST['description'])) {
        $gallery_id = $_POST['gallery_id'];
        $description = $_POST['description'];

        if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
            
            $stmt = $con->prepare("UPDATE gallery SET description=?, image=? WHERE gal_id=?");
            $stmt->bind_param("sbi", $description, $null, $gallery_id);
            $stmt->send_long_data(1, $image);
        } else {
            $stmt = $con->prepare("UPDATE gallery SET description=? WHERE gal_id=?");
            $stmt->bind_param("si", $description, $gallery_id);
        }

        if ($stmt) {
            if ($stmt->execute()) {
                echo "<script>alert('Gallery updated successfully'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error: Failed to prepare the query.'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php';</script>";
        }
    } elseif (isset($_POST['delete_news_id'])) {
        $news_id = $_POST['delete_news_id'];
        $stmt = $con->prepare("DELETE FROM news WHERE news_id=?");
        $stmt->bind_param("i", $news_id);
        if ($stmt->execute()) {
            echo "News item deleted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['delete_gallery_id'])) {
        $gallery_id = $_POST['delete_gallery_id'];
        $stmt = $con->prepare("DELETE FROM gallery WHERE gal_id=?");
        $stmt->bind_param("i", $gallery_id);
        if ($stmt->execute()) {
            echo "Gallery item deleted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $con->close();
}
?>

    <script>

    function closeModal(newsSettingModal1) {
            const modal = document.getElementById(newsSettingModal1);
            modal.style.display = 'none';
        }


        function openUpdateModalForNews(id, title, content, link) {
    document.getElementById('update-newsid').value = id;
    document.getElementById('update-title').value = title;
    document.getElementById('update-content').value = content;
    document.getElementById('update-link').value = link;
    document.getElementById('UpdateNews').style.display = 'block'; 
}

    function openUpdateModalForGallery(id, description) {
        document.getElementById('update-gallery-id').value = id;
        document.getElementById('update-gallery-description').value = description;
        document.getElementById('updateGalleryModal').style.display = 'block'; 
    }

    function deleteNews(id) {
    if (confirm('Are you sure you want to delete this news article?')) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert('News article deleted successfully.');
                location.reload(); 
            }
        };
        xhttp.open('POST', 'newsModal.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('delete_news_id=' + id);
    }
}


    function deleteGallery(id) {
        if (confirm('Are you sure you want to delete this gallery item?')) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert('Gallery item deleted successfully.');
                    location.reload(); 
                }
            };
            xhttp.open('POST', 'newsModal.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send('delete_gallery_id=' + id);
        }
    }
</script>

    </div>
</body>
</html>