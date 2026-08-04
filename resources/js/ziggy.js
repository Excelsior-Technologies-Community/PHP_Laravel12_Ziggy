const Ziggy = {"url":"http:\/\/127.0.0.1:8000","port":8000,"defaults":{},"routes":{"home":{"uri":"\/","methods":["GET","HEAD"]},"about":{"uri":"about","methods":["GET","HEAD"]},"contact":{"uri":"contact","methods":["GET","HEAD"]},"user.profile":{"uri":"user\/{id}","methods":["GET","HEAD"],"parameters":["id"]},"product.show":{"uri":"product\/{id?}","methods":["GET","HEAD"],"parameters":["id"]},"post.details":{"uri":"post\/{category}\/{slug}","methods":["GET","HEAD"],"parameters":["category","slug"]},"route.inspector":{"uri":"route-inspector","methods":["GET","HEAD"]},"route.playground":{"uri":"route-playground","methods":["GET","HEAD"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
