<?php
// require_once('includes/session.php');

include('includes/db_connect.php');
include('includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/navbar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1>Menu Management</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuModal">
                    <i class="fa fa-plus"></i> Add New Menu
                </button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $qry = $conn->query("SELECT p.*, c.name as category FROM product_list p LEFT JOIN category_list c ON c.id = p.category_id ORDER BY p.id DESC");
                                while($row = $qry->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <img src="assets/uploads/<?php echo $row['img_path'] ?>"
                                            alt="<?php echo $row['name'] ?>"
                                            class="img-thumbnail"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['category'] ?></td>
                                    <td><?php echo substr($row['description'], 0, 50) . '...' ?></td>
                                    <td>$<?php echo number_format($row['price'], 2) ?></td>
                                    <td>
                                        <?php if($row['status'] == 1): ?>
                                            <span class="badge bg-success">Available</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Unavailable</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit_menu" 
                                                type="button"
                                                data-id="<?php echo $row['id'] ?>"
                                                data-name="<?php echo $row['name'] ?>"
                                                data-category_id="<?php echo $row['category_id'] ?>"
                                                data-description="<?php echo $row['description'] ?>"
                                                data-price="<?php echo $row['price'] ?>"
                                                data-status="<?php echo $row['status'] ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete_menu" 
                                                type="button"
                                                data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Menu Modal -->
            <div class="modal fade" id="menuModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="menu-form" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title">Menu Form</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div id="msg"></div>
                                <input type="hidden" name="id" id="menu_id">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="menu_name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-select" name="category_id" id="category_id" required>
                                        <?php
                                        $cats = $conn->query("SELECT * FROM category_list ORDER BY name ASC");
                                        while($row = $cats->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" class="form-control" name="price" id="price" step="0.01" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" name="img" id="img" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="1">Available</option>
                                        <option value="0">Unavailable</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
$(document).ready(function() {
    // Reset form when modal is closed
    $('#menuModal').on('hidden.bs.modal', function () {
        $('#menu-form')[0].reset();
        $('#menu_id').val('');
        $('#msg').html('');
    });

    // Form Submit
    $('#menu-form').submit(function(e) {
        e.preventDefault();
        $('#msg').html('');
        
        $.ajax({
            url: 'ajax.php?action=save_menu',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if(resp == 1) {
                    alert('Menu saved successfully');
                    location.reload();
                } else {
                    $('#msg').html('<div class="alert alert-danger">An error occurred</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#msg').html('<div class="alert alert-danger">An error occurred: ' + error + '</div>');
            }
        });
    });

    // Edit Menu
    $('.edit_menu').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var category_id = $(this).data('category_id');
        var description = $(this).data('description');
        var price = $(this).data('price');
        var status = $(this).data('status');

        $('#menu_id').val(id);
        $('#menu_name').val(name);
        $('#category_id').val(category_id);
        $('#description').val(description);
        $('#price').val(price);
        $('#status').val(status);
        
        $('#menuModal').modal('show');
    });

    // Delete Menu
    $('.delete_menu').click(function() {
        var id = $(this).data('id');
        
        if(confirm('Are you sure to delete this menu?')) {
            $.ajax({
                url: 'ajax.php?action=delete_menu',
                method: 'POST',
                data: {id: id},
                success: function(resp) {
                    if(resp == 1) {
                        alert('Menu deleted successfully');
                        location.reload();
                    } else {
                        alert('An error occurred');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>