<?php ?>
<h4>ORGANIZATION MENU</h4>

<ul id="leftMenuAdmin">
    <li><a href="home.php?org_code=<?= $org_code?>"><?= $org_name ?></a></li>    
    <ul>
        <li><a href="org_profile.php?org_code=<?= $org_code?>">Profile</a></li>
        <li><a href="sanctioned_post.php?org_code=<?= $org_code?>">Sanctioned Post</a></li>
        <ul>
            <li><a href="sanctioned_post_sorted.php?org_code=<?= $org_code?>">Search</a></li>
            <li><a href="update_sanctioned_post.php?org_code=<?= $org_code?>">Add</a></li>
            <li><a href="sanctioned_post.php?org_code=<?= $org_code?>">Report</a></li>
        </ul>
        <li><a href="sanctioned_post.php?org_code=<?= $org_code?>">Sanctioned Post</a></li>
        <ul>
            <li><a href="sanctioned_post_sorted.php?org_code=<?= $org_code?>">Search</a></li>
            <li><a href="update_sanctioned_post.php?org_code=<?= $org_code?>">Add</a></li>
            <li><a href="sanctioned_post.php?org_code=<?= $org_code?>">Report</a></li>
        </ul>
    </ul>    
</ul>

<!--
|-- Search ** (List + edit/delete)
|-- | -- Org Home - SELECTED_ORG_NAME
|-- | -- | -- Profile (Editable page)
|-- | -- | -- Sanctioned Post
|-- | -- | -- | -- Search ** (List + edit/delete)
|-- | -- | -- | -- Add
|-- | -- | -- | -- Reports
|-- | -- | -- Employee
|-- | -- | -- | -- Search ** (List+ edit/delete/Move Out)
|-- | -- | -- | -- Add
|-- | -- | -- | -- Move Request
|-- | -- | -- | -- Match Employee
|-- | -- | -- | -- Reports
|-- | -- | -- Org Admin Users
|-- | -- | -- Reports
-->