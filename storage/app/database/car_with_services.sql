SELECT cars.car_id,
       cars.type,
       cars.registered,
       (CASE WHEN cars.ownbrand = 0 THEN 'Nem' ELSE 'Igen' END)                                as ownbrand,
       cars.accident,
       services.event,
       (CASE WHEN services.eventtime IS NULL THEN cars.registered ELSE services.eventtime END) as eventtime,
       services_max.lognumber
FROM (
         SELECT car_id, client_id, max(lognumber) AS lognumber
         FROM services
         WHERE client_id = 56499
         GROUP BY car_id, client_id
     ) AS services_max
         INNER JOIN services
                    ON (services_max.client_id = services.client_id AND services_max.car_id = services.car_id AND
                        services_max.lognumber = services.lognumber)
         INNER JOIN cars ON (cars.client_id = services.client_id AND cars.car_id = services.car_id)
