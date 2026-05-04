from rest_framework import viewsets, filters
from .models import Journal
from .serializers import JournalSerializer

class JournalViewSet(viewsets.ModelViewSet):
    queryset = Journal.objects.all().order_by('-date_edition')
    serializer_class = JournalSerializer
    filter_backends = [filters.SearchFilter]
    search_fields = ['matricule', 'editeur', 'description']
