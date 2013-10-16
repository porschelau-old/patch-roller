#Patch Roller#

This is a command line tool to help manage the schema that an application might have and will roll up the patches onto the 
database for the user. 

#Patch Organization#
We are organizing the patches in to a series of sortable files in a directory. e.g. fixup20131003.sql. The naming convention is to 
prevent 1. merge conflict during git merge, and 2. sequencing conflict during merge time. The key thing is that we want to allow the 
programmer to be confident that their patches will not cause any harm to the patches that other team member had submitted.

##Patch Application##
###Apply All Patches###
To apply all the all the patches from start to finish, you can run this command:

<pre><code>php cliner.php patch apply all [options]</code></pre>

This command will iterate through the patches you have in the directory, and apply the patches that had not been apply yet. Since we name our patches in a sortable manner, the optimal way to handle this is to look for the last applied patch. 

####Options####
Optional parameter are expressed as key value pairs on the command.

<pre><code>php cliner.php patch apply all [key]=[value]</code></pre>

<table>
    <tr>
        <th>Options<th>
        <th>Description</th>
    <tr>
        <td>flush_db</td>
        <td>we will drop all the tables from the db and apply the schema from the top. **very dangerous** use this with cautions</td>
    </tr>
</table>

###Apply One Patch###
You can select one patch and apply it to the system. Of course, if that patch is deemed applied, we will not apply the patch again

<pre><code>php cliner.php patch apply [patch_name]</code></pre>