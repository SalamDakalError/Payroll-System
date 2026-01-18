document.addEventListener('DOMContentLoaded', ()=>{
  const now = new Date();
  document.querySelectorAll('.now-date').forEach(el=>el.textContent = now.toLocaleDateString());

  // small helper to load list via fetch
  window.apiFetch = async (url, opts={})=>{
    try{
      const res = await fetch(url, {credentials: 'include', ...opts});
      return await res.json();
    }catch(e){console.error('apiFetch',e);return null}
  }
});
