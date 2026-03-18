<?php include('header.php'); ?>

<div class="container">
    <h1 style="text-align:center; color:var(--primary);">Waste Transformation Guide ♻️</h1>
    <p style="text-align:center;">Understand how your dry waste becomes a treasure.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 30px;">
        <?php
        $waste_data = [
            "Paper Waste" => "Recycled paper, bags, greeting cards, notebooks",
            "Plastic Bottles" => "Flower pots, eco-bricks, lamps, bird feeders",
            "Cardboard" => "Storage boxes, furniture, toys, laptop stands",
            "Glass Bottles" => "Vases, lamps, candle holders, wind chimes",
            "Metal Cans" => "Pen stands, planters, lanterns, storage tins",
            "Old Clothes" => "Carry bags, cushion covers, quilts, rugs",
            "E-Waste" => "Art crafts, spare parts, DIY gadgets",
            "Rubber Tires" => "Garden swings, planters, shoe soles, mats",
            "Wood Waste" => "Shelves, birdhouses, photo frames, toys",
            "Plastic Bags" => "Handbags, floor mats, raincoats, rope"
        ];

        foreach($waste_data as $type => $products) {
            echo "
            <div style='border: 1px solid #ddd; padding: 20px; border-radius: 12px; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>
                <h3 style='color: var(--primary); margin-top: 0;'>$type</h3>
                <p style='font-size: 0.9rem; color: #555;'><strong>Useful Products:</strong><br>$products</p>
            </div>";
        }
        ?>
    </div>
</div>