var listPresetThemes = async (pg, filters) => {
    presetThemesList = document.getElementById("preset_themes");
    
    const data = await fetch(`${getUriRoute(getInstitute())}/configuracoes-instituto/temas/preset/dados-lista?pg=${pg}&&${filters}`);
    const html = await data.text();
    presetThemesList.innerHTML = html;
    activeThemesActivity();
}