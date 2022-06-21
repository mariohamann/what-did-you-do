"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[499],{3860:(e,t)=>{t.Z=(e,t)=>{const o=e.__vccOpts||e;for(const[e,n]of t)o[e]=n;return o}},5282:(e,t,o)=>{o.d(t,{Z:()=>c});var n=o(6521),r=o(5050),s={class:"md:grid md:grid-cols-3 md:gap-6"},a={class:"mt-5 md:mt-0 md:col-span-2"},l={class:"px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg"};const c={__name:"ActionSection",setup:function(e){return function(e,t){return(0,n.openBlock)(),(0,n.createElementBlock)("div",s,[(0,n.createVNode)(r.Z,null,{title:(0,n.withCtx)((function(){return[(0,n.renderSlot)(e.$slots,"title")]})),description:(0,n.withCtx)((function(){return[(0,n.renderSlot)(e.$slots,"description")]})),_:3}),(0,n.createElementVNode)("div",a,[(0,n.createElementVNode)("div",l,[(0,n.renderSlot)(e.$slots,"content")])])])}}}},5616:(e,t,o)=>{o.d(t,{Z:()=>s});var n=o(6521),r=["type"];const s={__name:"DangerButton",props:{type:{type:String,default:"button"}},setup:function(e){return function(t,o){return(0,n.openBlock)(),(0,n.createElementBlock)("button",{type:e.type,class:"inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition"},[(0,n.renderSlot)(t.$slots,"default")],8,r)}}}},8307:(e,t,o)=>{o.d(t,{Z:()=>u});var n=o(6521),r=o(6955),s={class:"px-6 py-4"},a={class:"text-lg"},l={class:"mt-4"},c={class:"flex flex-row justify-end px-6 py-4 bg-gray-100 text-right"};const u={__name:"DialogModal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup:function(e,t){var o=t.emit,u=function(){o("close")};return function(t,o){return(0,n.openBlock)(),(0,n.createBlock)(r.Z,{show:e.show,"max-width":e.maxWidth,closeable:e.closeable,onClose:u},{default:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",s,[(0,n.createElementVNode)("div",a,[(0,n.renderSlot)(t.$slots,"title")]),(0,n.createElementVNode)("div",l,[(0,n.renderSlot)(t.$slots,"content")])]),(0,n.createElementVNode)("div",c,[(0,n.renderSlot)(t.$slots,"footer")])]})),_:3},8,["show","max-width","closeable"])}}}},7089:(e,t,o)=>{o.d(t,{Z:()=>s});var n=o(6521),r=["value"];const s={__name:"Input",props:{modelValue:String},emits:["update:modelValue"],setup:function(e,t){var o=t.expose,s=(0,n.ref)(null);return(0,n.onMounted)((function(){s.value.hasAttribute("autofocus")&&s.value.focus()})),o({focus:function(){return s.value.focus()}}),function(t,o){return(0,n.openBlock)(),(0,n.createElementBlock)("input",{ref_key:"input",ref:s,class:"border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm",value:e.modelValue,onInput:o[0]||(o[0]=function(e){return t.$emit("update:modelValue",e.target.value)})},null,40,r)}}}},3277:(e,t,o)=>{o.d(t,{Z:()=>s});var n=o(6521),r={class:"text-sm text-red-600"};const s={__name:"InputError",props:{message:String},setup:function(e){return function(t,o){return(0,n.withDirectives)(((0,n.openBlock)(),(0,n.createElementBlock)("div",null,[(0,n.createElementVNode)("p",r,(0,n.toDisplayString)(e.message),1)],512)),[[n.vShow,e.message]])}}}},6955:(e,t,o)=>{o.d(t,{Z:()=>a});var n=o(6521),r={class:"fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50","scroll-region":""},s=[(0,n.createElementVNode)("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1)];const a={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup:function(e,t){var o=t.emit,a=e;(0,n.watch)((function(){return a.show}),(function(){a.show?document.body.style.overflow="hidden":document.body.style.overflow=null}));var l=function(){a.closeable&&o("close")},c=function(e){"Escape"===e.key&&a.show&&l()};(0,n.onMounted)((function(){return document.addEventListener("keydown",c)})),(0,n.onUnmounted)((function(){document.removeEventListener("keydown",c),document.body.style.overflow=null}));var u=(0,n.computed)((function(){return{sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"}[a.maxWidth]}));return function(t,o){return(0,n.openBlock)(),(0,n.createBlock)(n.Teleport,{to:"body"},[(0,n.createVNode)(n.Transition,{"leave-active-class":"duration-200"},{default:(0,n.withCtx)((function(){return[(0,n.withDirectives)((0,n.createElementVNode)("div",r,[(0,n.createVNode)(n.Transition,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:(0,n.withCtx)((function(){return[(0,n.withDirectives)((0,n.createElementVNode)("div",{class:"fixed inset-0 transform transition-all",onClick:l},s,512),[[n.vShow,e.show]])]})),_:1}),(0,n.createVNode)(n.Transition,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:(0,n.withCtx)((function(){return[(0,n.withDirectives)((0,n.createElementVNode)("div",{class:(0,n.normalizeClass)(["mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto",(0,n.unref)(u)])},[e.show?(0,n.renderSlot)(t.$slots,"default",{key:0}):(0,n.createCommentVNode)("",!0)],2),[[n.vShow,e.show]])]})),_:3})],512),[[n.vShow,e.show]])]})),_:3})])}}}},81:(e,t,o)=>{o.d(t,{Z:()=>s});var n=o(6521),r=["type"];const s={__name:"SecondaryButton",props:{type:{type:String,default:"button"}},setup:function(e){return function(t,o){return(0,n.openBlock)(),(0,n.createElementBlock)("button",{type:e.type,class:"inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"},[(0,n.renderSlot)(t.$slots,"default")],8,r)}}}},5050:(e,t,o)=>{o.d(t,{Z:()=>i});var n=o(6521),r={class:"md:col-span-1 flex justify-between"},s={class:"px-4 sm:px-0"},a={class:"text-lg font-medium text-gray-900"},l={class:"mt-1 text-sm text-gray-600"},c={class:"px-4 sm:px-0"};const u={},i=(0,o(3860).Z)(u,[["render",function(e,t){return(0,n.openBlock)(),(0,n.createElementBlock)("div",r,[(0,n.createElementVNode)("div",s,[(0,n.createElementVNode)("h3",a,[(0,n.renderSlot)(e.$slots,"title")]),(0,n.createElementVNode)("p",l,[(0,n.renderSlot)(e.$slots,"description")])]),(0,n.createElementVNode)("div",c,[(0,n.renderSlot)(e.$slots,"aside")])])}]])},2499:(e,t,o)=>{o.r(t),o.d(t,{default:()=>b});var n=o(6521),r=o(4896),s=o(5282),a=o(8307),l=o(5616),c=o(7089),u=o(3277),i=o(81),d=(0,n.createTextVNode)(" Delete Account "),m=(0,n.createTextVNode)(" Permanently delete your account. "),f=(0,n.createElementVNode)("div",{class:"max-w-xl text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain. ",-1),p={class:"mt-5"},y=(0,n.createTextVNode)(" Delete Account "),w=(0,n.createTextVNode)(" Delete Account "),x=(0,n.createTextVNode)(" Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. "),v={class:"mt-4"},h=(0,n.createTextVNode)(" Cancel "),g=(0,n.createTextVNode)(" Delete Account ");const b={__name:"DeleteUserForm",setup:function(e){var t=(0,n.ref)(!1),o=(0,n.ref)(null),b=(0,r.cI)({password:""}),V=function(){t.value=!0,setTimeout((function(){return o.value.focus()}),250)},k=function(){b.delete(route("current-user.destroy"),{preserveScroll:!0,onSuccess:function(){return N()},onError:function(){return o.value.focus()},onFinish:function(){return b.reset()}})},N=function(){t.value=!1,b.reset()};return function(e,r){return(0,n.openBlock)(),(0,n.createBlock)(s.Z,null,{title:(0,n.withCtx)((function(){return[d]})),description:(0,n.withCtx)((function(){return[m]})),content:(0,n.withCtx)((function(){return[f,(0,n.createElementVNode)("div",p,[(0,n.createVNode)(l.Z,{onClick:V},{default:(0,n.withCtx)((function(){return[y]})),_:1})]),(0,n.createVNode)(a.Z,{show:t.value,onClose:N},{title:(0,n.withCtx)((function(){return[w]})),content:(0,n.withCtx)((function(){return[x,(0,n.createElementVNode)("div",v,[(0,n.createVNode)(c.Z,{ref_key:"passwordInput",ref:o,modelValue:(0,n.unref)(b).password,"onUpdate:modelValue":r[0]||(r[0]=function(e){return(0,n.unref)(b).password=e}),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:(0,n.withKeys)(k,["enter"])},null,8,["modelValue","onKeyup"]),(0,n.createVNode)(u.Z,{message:(0,n.unref)(b).errors.password,class:"mt-2"},null,8,["message"])])]})),footer:(0,n.withCtx)((function(){return[(0,n.createVNode)(i.Z,{onClick:N},{default:(0,n.withCtx)((function(){return[h]})),_:1}),(0,n.createVNode)(l.Z,{class:(0,n.normalizeClass)(["ml-3",{"opacity-25":(0,n.unref)(b).processing}]),disabled:(0,n.unref)(b).processing,onClick:k},{default:(0,n.withCtx)((function(){return[g]})),_:1},8,["class","disabled"])]})),_:1},8,["show"])]})),_:1})}}}}}]);