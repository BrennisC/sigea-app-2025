<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <h2>Hola {{ $recipientName }},</h2>
    
    <p>Una nueva actividad ha ocurrido en nuestra plataforma:</p>
    
    <div style="background-color: #f5f5f5; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h3>{{ $activity->nombre }}</h3>
        <p>{{ $activity->descripcion }}</p>
        <p><small>{{ $activity->fecha_inicio->format('d/m/Y H:i') }}</small></p>
    </div>
    
    <p>Gracias por tu atención.</p>
</div>