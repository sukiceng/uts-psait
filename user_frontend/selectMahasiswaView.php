<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
        div.scroll {
            width: 600px;
            height: 400px;
            overflow: scroll;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Mahasiswa</h2>
                        <a href="insertMahasiswaView.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
                    </div>
                    <div class="scroll">
                        <?php
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_URL, 'http://localhost/uts-psait/api.php');
                        $res = curl_exec($curl);
                        $json = json_decode($res, true);

                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";    
                        echo "<th>NIM</th>";
                        echo "<th>Nama</th>";
                        echo "<th>Alamat</th>";
                        echo "<th>Mata Kuliah</th>";
                        echo "<th>Nilai</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach ($json["data"] as $data) {
                            echo "<tr>";
                            echo "<td>" . $data["nim"] . "</td>";
                            echo "<td>" . $data["nama"] . "</td>";
                            echo "<td>" . $data["alamat"] . "</td>";
                            echo "<td>" . $data["nama_mk"] . "</td>";
                            echo "<td>" . $data["nilai"] . "</td>";
                            echo "<td>";
                            echo '<a href="updateMahasiswaView.php?nim=' . $data["nim"] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo '<a href="deleteMahasiswaDo.php?nim=' . $data["nim"] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";

                        curl_close($curl);
                        ?>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
