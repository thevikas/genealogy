export function copyPersonObject(toobj,fromobj)
{
    if(fromobj == undefined || toobj==undefined)
    {
        console.log("undefined, returning",fromobj,toobj);
        return {};
    }

    toobj.firstname= fromobj.firstname;
    toobj.lastname= fromobj.lastname;
    toobj.name= fromobj.name;
    toobj.mobile = fromobj.mobile;
    toobj.email = fromobj.email;
    toobj.id_person = fromobj.id_person;
    toobj.age = fromobj.age;
    console.log("copy done",fromobj,toobj);
    return toobj;
}
