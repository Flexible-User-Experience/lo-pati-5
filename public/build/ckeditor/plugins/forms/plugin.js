CKEDITOR.plugins.add("forms",{requires:"dialog,fakeobjects",lang:"af,ar,az,bg,bn,bs,ca,cs,cy,da,de,de-ch,el,en,en-au,en-ca,en-gb,eo,es,es-mx,et,eu,fa,fi,fo,fr,fr-ca,gl,gu,he,hi,hr,hu,id,is,it,ja,ka,km,ko,ku,lt,lv,mk,mn,ms,nb,nl,no,oc,pl,pt,pt-br,ro,ru,si,sk,sl,sq,sr,sr-latn,sv,th,tr,tt,ug,uk,vi,zh,zh-cn",icons:"button,checkbox,form,hiddenfield,imagebutton,radio,select,select-rtl,textarea,textarea-rtl,textfield",hidpi:!0,onLoad:function(){CKEDITOR.addCss(".cke_editable form{border: 1px dotted #FF0000;padding: 2px;}\n"),CKEDITOR.addCss("img.cke_hidden{background-image: url("+CKEDITOR.getUrl(this.path+"images/hiddenfield.gif")+");background-position: center center;background-repeat: no-repeat;border: 1px solid #a9a9a9;width: 16px !important;height: 16px !important;}"),CKEDITOR.style.unstylableElements.push("select","option")},init:function(e){var t=e.lang,a=0,i={email:1,password:1,search:1,tel:1,text:1,url:1},o={checkbox:"input[type,name,checked,required]",radio:"input[type,name,checked,required]",textfield:"input[type,name,value,size,maxlength,required]",textarea:"textarea[cols,rows,name,required]",select:"select[name,size,multiple,required]; option[value,selected]",button:"input[type,name,value]",form:"form[action,name,id,enctype,target,method]",hiddenfield:"input[type,name,value]",imagebutton:"input[type,alt,src]{width,height,border,border-width,border-style,margin,float}"},d={checkbox:"input",radio:"input",textfield:"input",textarea:"textarea",select:"select",button:"input",form:"form",hiddenfield:"input",imagebutton:"input"},n=function(i,n,r){var l={allowedContent:o[n],requiredContent:d[n]};"form"==n&&(l.context="form"),e.addCommand(n,new CKEDITOR.dialogCommand(n,l)),e.ui.addButton&&e.ui.addButton(i,{label:t.common[i.charAt(0).toLowerCase()+i.slice(1)],command:n,toolbar:"forms,"+(a+=10)}),CKEDITOR.dialog.add(n,r)},r=this.path+"dialogs/";!e.blockless&&n("Form","form",r+"form.js"),n("Checkbox","checkbox",r+"checkbox.js"),n("Radio","radio",r+"radio.js"),n("TextField","textfield",r+"textfield.js"),n("Textarea","textarea",r+"textarea.js"),n("Select","select",r+"select.js"),n("Button","button",r+"button.js");var l=e.plugins.image;l&&!e.plugins.image2&&n("ImageButton","imagebutton",CKEDITOR.plugins.getPath("image")+"dialogs/image.js"),n("HiddenField","hiddenfield",r+"hiddenfield.js"),e.addMenuItems&&(n={checkbox:{label:t.forms.checkboxAndRadio.checkboxTitle,command:"checkbox",group:"checkbox"},radio:{label:t.forms.checkboxAndRadio.radioTitle,command:"radio",group:"radio"},textfield:{label:t.forms.textfield.title,command:"textfield",group:"textfield"},hiddenfield:{label:t.forms.hidden.title,command:"hiddenfield",group:"hiddenfield"},button:{label:t.forms.button.title,command:"button",group:"button"},select:{label:t.forms.select.title,command:"select",group:"select"},textarea:{label:t.forms.textarea.title,command:"textarea",group:"textarea"}},l&&(n.imagebutton={label:t.image.titleButton,command:"imagebutton",group:"imagebutton"}),!e.blockless&&(n.form={label:t.forms.form.menu,command:"form",group:"form"}),e.addMenuItems(n)),e.contextMenu&&(!e.blockless&&e.contextMenu.addListener((function(e,t,a){if((e=a.contains("form",1))&&!e.isReadOnly())return{form:CKEDITOR.TRISTATE_OFF}})),e.contextMenu.addListener((function(e){if(e&&!e.isReadOnly()){var t=e.getName();if("select"==t)return{select:CKEDITOR.TRISTATE_OFF};if("textarea"==t)return{textarea:CKEDITOR.TRISTATE_OFF};if("input"==t){var a=e.getAttribute("type")||"text";switch(a){case"button":case"submit":case"reset":return{button:CKEDITOR.TRISTATE_OFF};case"checkbox":return{checkbox:CKEDITOR.TRISTATE_OFF};case"radio":return{radio:CKEDITOR.TRISTATE_OFF};case"image":return l?{imagebutton:CKEDITOR.TRISTATE_OFF}:null}if(i[a])return{textfield:CKEDITOR.TRISTATE_OFF}}if("img"==t&&"hiddenfield"==e.data("cke-real-element-type"))return{hiddenfield:CKEDITOR.TRISTATE_OFF}}}))),e.on("doubleclick",(function(t){var a=t.data.element;if(!e.blockless&&a.is("form"))t.data.dialog="form";else if(a.is("select"))t.data.dialog="select";else if(a.is("textarea"))t.data.dialog="textarea";else if(a.is("img")&&"hiddenfield"==a.data("cke-real-element-type"))t.data.dialog="hiddenfield";else if(a.is("input")){switch(a=a.getAttribute("type")||"text"){case"button":case"submit":case"reset":t.data.dialog="button";break;case"checkbox":t.data.dialog="checkbox";break;case"radio":t.data.dialog="radio";break;case"image":t.data.dialog="imagebutton"}i[a]&&(t.data.dialog="textfield")}}))},afterInit:function(e){var t=(a=e.dataProcessor)&&a.htmlFilter,a=a&&a.dataFilter;CKEDITOR.env.ie&&t&&t.addRules({elements:{input:function(e){var t=(e=e.attributes).type;t||(e.type="text"),"checkbox"!=t&&"radio"!=t||"on"!=e.value||delete e.value}}},{applyToAll:!0}),a&&a.addRules({elements:{input:function(t){if("hidden"==t.attributes.type)return e.createFakeParserElement(t,"cke_hidden","hiddenfield")}}},{applyToAll:!0})}}),CKEDITOR.plugins.forms={_setupRequiredAttribute:function(e){this.setValue(e.hasAttribute("required"))}};