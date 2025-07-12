openapi: 3.0.0
info:
  title: API Superhéroes
  version: 1.0.0
  description: Documentación de la API para gestionar superhéroes

paths:
  /superheroe.php:
    post:
      summary: Crear un superhéroe
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              properties:
                Nombre:
                  type: string
                  example: "Infernox"
                Peso:
                  type: number
                  example: 90
                Altura:
                  type: number
                  example: 1.85
                Poder:
                  type: number
                  example: 95
                created:
                  type: string
                  format: date-time
                  example: "2025-07-05T18:30:00Z"
      responses:
        '200':
          description: Superhéroe guardado exitosamente
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                    example: Superhéroe guardado exitosamente
                  data:
                    type: object
                    properties:
                      id:
                        type: integer
                        example: 40
                      Nombre:
                        type: string
                        example: Infernox
                      Peso:
                        type: number
                        example: 90
                      Altura:
                        type: number
                        example: 1.85
                      Poder:
                        type: number
                        example: 95
                      created:
                        type: string
                        format: date-time
                        example: "2025-07-11T01:14:28+00:00"

    get:
      summary: Obtener superhéroes o uno específico
      parameters:
        - in: query
          name: id
          schema:
            type: integer
          required: false
          description: ID del superhéroe (opcional para obtener todos)
      responses:
        '200':
          description: Lista o detalle de superhéroes
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                      example: 40
                    Nombre:
                      type: string
                      example: Infernox
                    Peso:
                      type: number
                      example: 90
                    Altura:
                      type: number
                      example: 1.85
                    Poder:
                      type: number
                      example: 95
                    created:
                      type: string
                      format: date-time
                      example: "2025-07-11T01:14:28+00:00"
