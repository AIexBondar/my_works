from django.shortcuts import render

def ChatInit(request):
	return render(request, 'chat/index.html')