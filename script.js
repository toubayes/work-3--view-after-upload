function change_picture(){
    let image=document.getElementById("file_chossen").files[0];
    document.getElementById("image").src=URL.createObjectURL(image);
    
}