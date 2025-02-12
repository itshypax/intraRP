<table class="table table-striped" id="documentTable">
    <thead>
        <th scope="col">Dokumenten-Typ</th>
        <th scope="col">Doc-ID</th>
        <th scope="col">Ersteller</th>
        <th scope="col">Am</th>
        <th scope="col"></th>
    </thead>
    <tbody>
        <?php
        // Assuming you have established a database connection earlier ($conn)

        // Fetch user data and related documents in a single query
        $query = "SELECT pd.docid, pd.ausstellerid, pd.ausstelungsdatum, pd.type,
                 u.id, u.fullname, u.aktenid
          FROM personal_dokumente pd
          JOIN cirs_users u ON pd.ausstellerid = u.id
          WHERE pd.profileid = '$openedID'
          ORDER BY pd.ausstelungsdatum DESC";

        $dokuresult = mysqli_query($conn, $query) or die(mysqli_error($conn));

        // Define document types
        $arten = [
            0 => "Ernennungsurkunde",
            1 => "Beförderungsurkunde",
            2 => "Entlassungsurkunde",
            3 => "Ausbildungsvertrag",
            5 => "Ausbildungszertifikat",
            6 => "Lehrgangszertifikat",
            7 => "Lehrgangszertifikat (Fachdienste)",
            10 => "Schriftliche Abmahnung",
            11 => "Vorläufige Dienstenthebung",
            12 => "Dienstentfernung",
            13 => "Außerordentliche Kündigung",
        ];

        // Iterate through the documents
        while ($doks = mysqli_fetch_array($dokuresult)) {
            $austdatum = date("d.m.Y", strtotime($doks['ausstelungsdatum']));
            $docart = isset($arten[$doks['type']]) ? $arten[$doks['type']] : '';
            $path = '';

            if ($doks['type'] <= 3) {
                $path = "/dokumente/02/" . $doks['docid'];
                $bg = "bg-secondary";
            } elseif ($doks['type'] == 5 || $doks['type'] == 6 || $doks['type'] == 7) {
                $path = "/dokumente/03/" . $doks['docid'];
                $bg = "bg-dark";
            } elseif ($doks['type'] >= 10 && $doks['type'] <= 12) {
                $path = "/dokumente/schreiben.php?dok=" . $doks['docid'];
                $bg = "bg-danger";
            }

            $adminPermission = $admincheck;

            echo "<tr>";
            echo "<td><span class='badge $bg'>" . $docart . "</span></td>";
            echo "<td>" . $doks['docid'] .  "</td>";
            echo "<td>" . $doks['fullname'] . "</td>";
            echo "<td>" . $austdatum . "</td>";

            echo "<td>";
            echo "<a href='$path' class='btn btn-sm btn-primary' target='_blank'>Ansehen</a>";

            if ($adminPermission) {
                echo " <a href='/admin/personal/dokument-delete.php?id={$doks['docid']}&pid=$openedID' class='btn btn-sm btn-danger'><i class='fa-solid fa-trash'></i></a>";
            }

            echo "</td>";
            echo "</tr>";
        }
        ?>

    </tbody>
</table>