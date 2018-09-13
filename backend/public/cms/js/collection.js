function addCollectionRow(targetDiv, templateDiv)
{
    div      = $('#' + targetDiv);
    template = $('#' + templateDiv).html()
               .replace(/__index__/g, getNewCollectionIndex());
    $(template).show();
    div.append(template);
}


function removeCollectionRow(targetDiv)
{
    $(targetDiv).remove();
}


// Generates a UUID for a new Collection row's index
function getNewCollectionIndex() {
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
    });
    return uuid;
}
