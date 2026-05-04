from django.db import models

class Journal(models.Model):
    id_journal = models.AutoField(primary_key=True)
    matricule = models.IntegerField(unique=True)
    partie = models.CharField(max_length=50, null=True, blank=True)
    editeur = models.CharField(max_length=255)
    lieu_edition = models.CharField(max_length=255, null=True, blank=True)
    date_edition = models.DateField(null=True, blank=True)
    date_sortie = models.DateField(null=True, blank=True)
    lieu_stockage = models.CharField(max_length=255, null=True, blank=True)
    fichier_pdf = models.CharField(max_length=255, null=True, blank=True)
    prix = models.DecimalField(max_digits=10, decimal_places=2, null=True, blank=True)
    description = models.TextField(null=True, blank=True)

    class Meta:
        db_table = 'journal'
        managed = False # Satria efa misy ny table

    def __str__(self):
        return f"Journal {self.matricule} - {self.editeur}"
