# **Geofence Tracker** 📍

Geofence Tracker is een webapplicatie waarmee gebruikers hun locatie kunnen opslaan en controleren of deze zich binnen een bepaalde geofence bevindt. Dit project is ontwikkeld met **Laravel** als backend framework en maakt gebruik van **Mapbox** voor kaarten en geofencing-functionaliteiten.

---

## **Inhoudsopgave** 📑

- [Overzicht](#overzicht)
- [Functionaliteiten](#functionaliteiten)
- [Gebruik](#gebruik)
- [Technologieën](#technologieën)
- [Probleemoplossing](#probleemoplossing)
- [Sources](#Sources)

---

## **Overzicht** 🎯

Geofence Tracker stelt gebruikers in staat om locaties op te slaan en te valideren of ze zich binnen een vooraf gedefinieerde geofence bevinden. Het maakt gebruik van **Mapbox** voor het tonen van kaarten en het berekenen van de afstand tussen de gebruiker en de geofence. Als de gebruiker buiten de geofence komt, ontvangt deze een melding.

---

## **Functionaliteiten** 🚀

- **Geofence beheer**: Creëert een cirkelvormige geofence van **352 meter** rond een specifieke locatie (bijvoorbeeld Brussel).
- **Locatie validatie**: Valideert of een gebruiker zich binnen of buiten de geofence bevindt.
- **Kaartweergave**: Visualiseer de locatie van de gebruiker en de geofence op een **Mapbox**-kaart.
- **Gebruikersauthenticatie**: Alleen ingelogde gebruikers kunnen hun locaties beheren en opslaan.
- **Realtime locatie**: Gebruikers kunnen hun locatie opslaan via de applicatie.

---

## **Gebruik**📍
Opslaan van een locatie:
Log in met een gebruikersaccount.
Verplaats de rode marker naar de gewenste locatie.
Klik op "Save Location". Als de locatie binnen de geofence ligt, wordt deze succesvol opgeslagen.
Validatie:
Binnen geofence: Als de locatie binnen de geofence ligt, wordt de locatie opgeslagen met een succesmelding.
Buiten geofence: Als de locatie buiten de geofence ligt, verschijnt een foutmelding:
"The location is outside the geofence."

## **Technologieën**🛠️
Backend: Laravel 11
Frontend: Blade templates, Mapbox GL JS
Database: SQLite (makkelijk voor ontwikkeling)
Kaartenservice: Mapbox


## **Probleemoplossing**⚠️
Probleem met Life360 API:
In eerste instantie werd de Life360 API overwogen voor locatie-tracking, maar deze was niet meer beschikbaar. Na het onderzoeken van alternatieven zoals Google Maps API en OpenStreetMap is uiteindelijk gekozen voor Mapbox vanwege de uitgebreide mogelijkheden voor kaarten en geofencing, evenals de eenvoudige integratie.

Fouten die je kunt tegenkomen:
Integrity constraint violation: Zorg ervoor dat migraties correct zijn uitgevoerd en dat een user_id wordt gekoppeld aan de locatie.
Access level to middleware: Verzeker je ervan dat alle methoden in je controllers op zijn minst public zijn.

## **Sources**🙏

https://www.mapbox.com/
https://medium.com/@abdurrehman-520/unlock-the-power-of-geofencing-in-flutter-with-haversine-formula-21b8203b1a5
https://www.polygongroup.com/nl-NL/
https://stackoverflow.com/questions/55657876/geofencing-using-google-maps-in-laravel
https://www.surfsidemedia.in/post/implementing-real-time-geolocation-features-in-laravel
