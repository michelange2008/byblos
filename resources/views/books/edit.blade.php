<form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="title">Titre</label>
    <input type="text" name="title" value="Mon livre test">

    <label for="author">Auteur</label>
    <input type="text" name="author" value="Un auteur">

    <label for="cover">Couverture</label>
    <input type="file" name="cover">

    <button type="submit">Enregistrer</button>
</form>
