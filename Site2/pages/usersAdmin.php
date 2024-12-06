<div class="col-sm-6 col-md-6 col-lg-12 left">
    <!--Users-->
    <?php
    $conn = connectDb();
    $select_admins_query = "SELECT u.id, u.login, u.profile_picture, r.role FROM users u 
              JOIN roles r on r.id = u.role_id";
    $result = $conn->query($select_admins_query)->fetchAll(PDO::FETCH_OBJ);


    ?>
    <h2>Users</h2>
    <!--    <form action="index.php?page=usersAdmin" method="post" class="input-group" enctype="multipart/form-data">-->
    <table class="table table-striped w-75 text-center ms-auto me-auto">
        <thead>
        <tr>
            <th>Id</th>
            <th>Login</th>
            <th>Role</th>
            <th>Profile picture</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($result as $row) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row->id) ?></td>
                <td><?php echo htmlspecialchars($row->login) ?></td>
                <td><?php echo htmlspecialchars($row->role) ?></td>
                <td>
                    <img style="max-width:50px; max-height:50px" class="img-fluid rounded-circle"
                         src="<?php echo $row->profile_picture ?>" alt="No image">
                </td>
                <td>
                    <form action="index.php?page=usersAdmin" method="post">
                        <input hidden name="user_id" value="<?php echo $row->id ?>">
                        <input type="submit" class="btn btn-sm btn-primary me-2" name="promoteToAdmin"
                               value="Promote to Admin">
                        <input type="submit" class="btn btn-sm btn-danger me-2" name="demoteToUser"
                               value="Demote to User">
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <!--        <select class="form-select me-2" name="user_id">-->
    <!--            <option value="">Select user</option>-->
    <!--            --><?php
    //            $select_all_users_query = "SELECT u.id, u.login, r.role FROM users u
    //              JOIN roles r on r.id = u.role_id";
    //            $result = $conn->query($select_all_users_query)->fetchAll(PDO::FETCH_OBJ);
    //            foreach ($result as $row) {
    //                echo "<option value='" . $row->id . "'>" . $row->login . ": " . $row->role . "</option>";
    //            }
    //            ?>
    <!--        </select>-->
    <!--        <input type="submit" class="btn btn-sm btn-primary me-2" name="promoteToAdmin" value="Promote to Admin">-->
    <!--        <input type="submit" class="btn btn-sm btn-danger me-2" name="demoteToUser" value="Demote to User">-->
    <!--    </form>-->

    <?php
    if (isset($_POST['promoteToAdmin'])) {
        $user_id = trim(htmlspecialchars($_POST['user_id']));
        if (empty($user_id)) {
            echo "<span style='color:red;'><h3>Select user!</h3></span>";
            exit();
        }
        try {
            $admin_role_id = $conn->query("SELECT id FROM roles WHERE role = 'Admin'")->fetchColumn();
            if (empty($admin_role_id)) {
                echo "<span style='color:red;'><h3>Failed to fetch admin role id!</h3></span>";
                exit();
            }

            $is_already_admin_query = "SELECT role FROM users u 
              JOIN roles r on r.id = u.role_id 
              WHERE r.role = 'Admin' AND u.id = :user_id";
            $stmt = $conn->prepare($is_already_admin_query);
            if ($stmt->execute([':user_id' => $user_id]) and $stmt->rowCount() > 0) {
                echo "<span style='color:red;'><h3>User is already admin!</h3></span>";
                exit();
            }
            $promote_query = "UPDATE roles SET role = 'Admin' WHERE id = :user_id; 
                             UPDATE users SET role_id = :role_id WHERE id = :user_id;";
            $stmt = $conn->prepare($promote_query);
            $stmt->execute([':user_id' => $user_id, ':role_id' => $admin_role_id]);

            echo "<h3/><span style='color:green;'>User promoted!</span>";
            echo "<script>" . "window.location=document.location.href;" . "</script>";

            return true;
        } catch (PDOException $e) {
            echo "<span style='color:red;'><h3>Failed to promote user!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";

            return false;
        }
    }
    if (isset($_POST['demoteToUser'])) {
        $user_id = trim(htmlspecialchars($_POST['user_id']));
        if (empty($user_id)) {
            echo "<span style='color:red;'><h3>Select user!</h3></span>";
            exit();
        }
        try {
            $user_role_id = $conn->query("SELECT id FROM roles WHERE role = 'User'")->fetchColumn();
            if (empty($user_role_id)) {
                echo "<span style='color:red;'><h3>Failed to fetch user role id!</h3></span>";
                exit();
            }

            $is_already_user_query = "SELECT role FROM users u 
              JOIN roles r on r.id = u.role_id 
              WHERE r.role = 'User' AND u.id = :user_id";
            $stmt = $conn->prepare($is_already_user_query);
            if ($stmt->execute([':user_id' => $user_id]) and $stmt->rowCount() > 0) {
                echo "<span style='color:red;'><h3>User is already not admin!</h3></span>";
                exit();
            }
            $demote_query = "UPDATE roles SET role = 'User' WHERE id = :user_id; 
                             UPDATE users SET role_id = :role_id WHERE id = :user_id;";
            $stmt = $conn->prepare($demote_query);
            $stmt->execute([':user_id' => $user_id, ':role_id' => $user_role_id]);

            echo "<h3/><span style='color:green;'>User demoted!</span>";
            echo "<script>" . "window.location=document.location.href;" . "</script>";

            return true;
        } catch (PDOException $e) {
            echo "<span style='color:red;'><h3>Failed to demote user!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";

            return false;
        }
    }
    ?>
</div>