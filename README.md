openapi: 3.0.3
info:
  title: API de Superhéroes
  version: 1.0.0
  description: API para gestionar superhéroes y obtener una lista paginada desde un archivo PHP.

servers:
  - url: http://localhost/Superheroes

paths:
  /superheroe.php:
    get:
      summary: Obtener lista paginada de superhéroes
      description: Devuelve una lista paginada de superhéroes desde un archivo JSON local.
      parameters:
        - in: query
          name: page
          schema:
            type: integer
            minimum: 1
            default: 1
          required: false
          description: Número de página (comienza en 1)
        - in: query
          name: limit
          schema:
            type: integer
            minimum: 1
            default: 10
          required: false
          description: Número de superhéroes por página
      responses:
        '200':
          description: Lista paginada de superhéroes
          content:
            application/json:
              schema:
                type: object
                properties:
                  page:
                    type: integer
                  per_page:
                    type: integer
                  total:
                    type: integer
                  total_pages:
                    type: integer
                  data:
                    type: array
                    items:
                      $ref: '#/components/schemas/Superheroe'
        '400':
          description: Petición inválida
        '404':
          description: No se encontraron superhéroes

    post:
      summary: Crear un nuevo superhéroe
      description: Agrega un nuevo superhéroe al archivo JSON.
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/Superheroe'
      responses:
        '200':
          description: Superhéroe creado exitosamente
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                    example: "Superhéroe creado exitosamente"
                  data:
                    $ref: '#/components/schemas/Superheroe'
        '400':
          description: Faltan campos obligatorios
          content:
            application/json:
              schema:
                type: object
                properties:
                  error:
                    type: string
                    example: "Faltan campos obligatorios: Nombre, Altura, Poder"

    delete:
      summary: Eliminar un superhéroe
      description: Elimina un superhéroe por su ID.
      parameters:
        - in: query
          name: id
          schema:
            type: integer
          required: true
          description: ID del superhéroe a eliminar
      responses:
        '200':
          description: Superhéroe eliminado exitosamente
        '400':
          description: ID no proporcionado
        '404':
          description: Superhéroe no encontrado

components:
  schemas:
    Superheroe:
      type: object
      required:
        - id
        - Nombre
        - Peso
        - Altura
        - Poder
      properties:
        id:
          type: integer
          example: 1
        Nombre:
          type: string
          example: Infernox
        Peso:
          type: integer
          example: 90
        Altura:
          type: number
          format: float
          example: 1.85
        Poder:
          type: integer
          example: 95
        created:
          type: string
          format: date-time
          example: "2025-07-05T18:30:00Z"
