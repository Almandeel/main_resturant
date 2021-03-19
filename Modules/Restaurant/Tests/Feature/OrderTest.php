<?php

namespace Modules\Restaurant\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function can_create_order_for_table()
    {
        $this->seed();

        $table = \Modules\Restaurant\Models\Table::create(['number' => 10, 'status' => 1]);

        $waiter = \Modules\Restaurant\Models\Waiter::create([
            'name' => $this->faker()->name(),
            'phone' => (int) $this->faker()->e164PhoneNumber,
            'address' => $this->faker()->address,
        ]);

        $items = [
            \App\Item::create(['name' => 'item0'])->id,
            \App\Item::create(['name' => 'item1'])->id,
            \App\Item::create(['name' => 'item2'])->id,
        ];

        $response = $this->actingAs(\App\User::first())->post(route('orders.store'), [
            'amount' => 1000,
            'table_id' => $table->id,
            'waiter_id' => $waiter->id,
            'items' => $items,
            'quantity' => [1, 2, 2],
            'price' => [1, 2, 2],
        ]);

        $response->assertRedirect(route('orders.index'));

        $order = \Modules\Restaurant\Models\Order::query()
            ->where('type', 1)
            ->where('status', 0)
            ->where('amount', 1000)
            ->where('table_id', $table->id)
            ->where('waiter_id', $waiter->id)
            ->where('driver_id', null)
            ->get();

        $order = $order->first();

        $this->assertNotNull($order);

        $this->assertSame($table->id, $order->table->id);
        $this->assertSame($waiter->id, $order->waiter->id);

        $this->assertEquals(1, $order->type);
        $this->assertNull($order->driver_id);
    }

    /** @test */
    public function can_create_order_for_driver()
    {
        $this->withoutExceptionHandling();
        $this->seed();

        $driver = \Modules\Restaurant\Models\Driver::create([
            'name' => $this->faker()->name(),
            'phone' => (int) $this->faker()->e164PhoneNumber,
            'address' => $this->faker()->address,
        ]);

        $items = [
            \App\Item::create(['name' => 'item0'])->id,
            \App\Item::create(['name' => 'item1'])->id,
            \App\Item::create(['name' => 'item2'])->id,
        ];

        $response = $this->actingAs(\App\User::first())->post(route('orders.store'), [
            'amount' => 1000,
            'driver_id' => $driver->id,
            'items' => $items,
            'quantity' => [1, 2, 2],
            'price' => [1, 2, 2],
        ]);

        $response->assertRedirect(route('orders.index'));

        $order = \Modules\Restaurant\Models\Order::query()
            ->where('type', 2)
            ->where('status', 0)
            ->where('amount', 5)
            ->where('table_id', null)
            ->where('waiter_id', null)
            ->where('driver_id', $driver->id)
            ->get();

        // dd($order);
        $order = $order->first();
        $this->assertNotNull($order);

        $this->assertSame($driver->id, $order->driver->id);

        $this->assertEquals(2, $order->type);
        $this->assertNull($order->table_id);
        $this->assertNull($order->waiter_id);
    }

    /** @test */
    public function can_update_items_in_local_order()
    {
        $this->withoutExceptionHandling();
        $this->seed();

        $table = \Modules\Restaurant\Models\Table::create(['number' => 10, 'status' => 1]);

        $waiter = \Modules\Restaurant\Models\Waiter::create(['name' => $this->faker()->name(), 'phone' => (int) $this->faker()->e164PhoneNumber, 'address' => $this->faker()->address]);

        $items = [
            \App\Item::create(['name' => 'item0'])->id,
            \App\Item::create(['name' => 'item1'])->id,
            \App\Item::create(['name' => 'item2'])->id,
        ];

        $this->actingAs(\App\User::first())->post(route('orders.store'), [
            'amount' => 1000,
            'table_id' => $table->id,
            'waiter_id' => $waiter->id,
            'items' => $items,
            'quantity' => [1, 2, 2],
            'price' => [1, 2, 2],
        ]);

        $order = \Modules\Restaurant\Models\Order::first();

        $response = $this->actingAs(\App\User::first())->put(route('orders.update', $order), [
            'items' => [
                \App\Item::create(['name' => 'item3'])->id,

            ],
            'quantity' => [1],
            'price' => [1],
        ]);

        $response->assertRedirect(route('orders.index'));

        $this->assertEquals(1, $order->items()->count());
    }

    /** @test */
    public function can_close_local_order()
    {
        $this->withoutExceptionHandling();
        $this->seed();

        $table = \Modules\Restaurant\Models\Table::create(['number' => 10, 'status' => 1]);

        $waiter = \Modules\Restaurant\Models\Waiter::create(['name' => $this->faker()->name(), 'phone' => (int) $this->faker()->e164PhoneNumber, 'address' => $this->faker()->address]);

        $items = [
            \App\Item::create(['name' => 'item0'])->id,
            \App\Item::create(['name' => 'item1'])->id,
            \App\Item::create(['name' => 'item2'])->id,
        ];

        $this->actingAs(\App\User::first())->post(route('orders.store'), [
            'amount' => 1000,
            'table_id' => $table->id,
            'waiter_id' => $waiter->id,
            'items' => $items,
            'quantity' => [1, 2, 2],
            'price' => [1, 2, 2],
        ]);

        $response = $this->actingAs(\App\User::first())->put(route('orders.update', 1), [
            'status' => 5,
        ]);

        $order = \Modules\Restaurant\Models\Order::first();

        $response->assertRedirect(route('orders.index'));

        $this->assertNotNull($order->closed_at);
    }
}
