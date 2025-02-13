import{S as _}from"./SectionTitle-D967_lrX.js";import{d as w,o as h,b as d,a as t,w as i,m as n,r as f,z as b,D as k,E as S,j as E,k as p,A as v,H as y,n as $,e as B}from"./app-DHZlc4yh.js";const C={class:"md:grid md:grid-cols-3 md:gap-6"},z={class:"mt-5 md:mt-0 md:col-span-2"},D={class:"px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg"},V={__name:"ActionSection",setup(l){return(a,e)=>(h(),w("div",C,[d(_,null,{title:i(()=>[n(a.$slots,"title")]),description:i(()=>[n(a.$slots,"description")]),_:3}),t("div",z,[t("div",D,[n(a.$slots,"content")])])]))}},M={class:"fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50","scroll-region":""},W={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(l,{emit:a}){const e=l,x=a,c=f(),r=f(e.show);b(()=>e.show,()=>{var s;e.show?(document.body.style.overflow="hidden",r.value=!0,(s=c.value)==null||s.showModal()):(document.body.style.overflow=null,setTimeout(()=>{var o;(o=c.value)==null||o.close(),r.value=!1},200))});const m=()=>{e.closeable&&x("close")},u=s=>{s.key==="Escape"&&(s.preventDefault(),e.show&&m())};k(()=>document.addEventListener("keydown",u)),S(()=>{document.removeEventListener("keydown",u),document.body.style.overflow=null});const g=E(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[e.maxWidth]);return(s,o)=>(h(),w("dialog",{class:"z-50 m-0 min-h-full min-w-full overflow-y-auto bg-transparent backdrop:bg-transparent",ref_key:"dialog",ref:c},[t("div",M,[d(y,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:i(()=>[p(t("div",{class:"fixed inset-0 transform transition-all",onClick:m},o[0]||(o[0]=[t("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1)]),512),[[v,l.show]])]),_:1}),d(y,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:i(()=>[p(t("div",{class:$(["mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto",g.value])},[r.value?n(s.$slots,"default",{key:0}):B("",!0)],2),[[v,l.show]])]),_:3})])],512))}};export{V as _,W as a};
