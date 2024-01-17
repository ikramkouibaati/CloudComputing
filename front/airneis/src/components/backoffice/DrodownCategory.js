function DropdownCategory({ categories, selectedCategoryId, onChange }) {
    return (
        <div className="form-group">
            <label>Catégorie</label>
            <select name="id_categorie" value={selectedCategoryId} className="form-control" onChange={onChange}>
                <option value="">Choisir une catégorie</option>
                {categories.map(category => (
                    <option key={category.id_categorie} value={category.id_categorie}>
                        {category.nom_categorie}
                    </option>
                ))}
            </select>
        </div>
    );
}

export default DropdownCategory;
