<?php
session_start()
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://cdn.tailwindcss.com"></script>
    <Style>
        #editi_btn{
            background-color: green;
            color: white;
            border-radius: 5px;
            padding: 5px;
        }
        #del_btn{
            background-color: red;
            color: white;
            border-radius: 5px;
            padding: 5px;
        }
        p{

            text-align: center;
            color: red;
        }
        th{
            background-color:blue;
        }
    </Style>

</head>

<body class="bg-gray-100">
<header>
        <?php  require "./view/partials/header.php" ?>
    </header>
    <div class="container mx-auto p-4">

    <div class="flex justify-between items-center mb-4">
            <p class="text-xl font-bold">All Users</p>
       

        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-purple-600 rounded">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Course</th>
                        <th class="px-4 py-2">Admin</th>
                        <th class="px-4 py-2">Edi_butn</th>
                        <th class="px-4 py-2">Del_btn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require "./controller/tableretrive.php";
                    $rowColor = 'bg-gray-100';
                    while ($user = mysqli_fetch_assoc($result)) :
                        ?>
                        <tr class="<?php echo $rowColor; ?>">
                            <td class="border px-4 py-2"><?php echo $user['id']; ?></td>
                            <td class="border px-4 py-2"><?php echo $user['Name']; ?></td>
                            <td class="border px-4 py-2"><?php echo $user['EmailAddress']; ?></td>
                            <td class="border px-4 py-2"><?php echo $user['CourseName']; ?></td>
                            <td class="border px-4 py-2"><?php echo $user['isAdmin'] ? 'Yes' : 'No'; ?></td>
                            <td class="border px-4 py-2">
                                <a href="./controller/edit_user.php?id=<?php echo $user['id']; ?>" id="editi_btn" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                
                            </td>
                            <td class="border px-4 py-2">
                            <a href="./controller/delete_user.php?id=<?php echo $user['id']; ?>"  id="del_btn"class="text-red-500 hover:text-red-700">Delete</a>
                            </td>
                        </tr>
                        <?php
                        // Toggle row color
                        $rowColor = ($rowColor == 'bg-gray-100') ? 'bg-white' : 'bg-gray-100';
                    endwhile;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>
