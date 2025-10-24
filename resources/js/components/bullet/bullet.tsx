function Bullet() {
  return (
    <div className="group relative h-9 w-full">
      <div className="absolute top-3 left-0 z-20 size-3 rounded-full bg-green-500" />
      <div className="absolute top-3 left-1.5 z-10 size-3 rounded-full bg-amber-500 duration-300 group-hover:translate-x-2" />
      <div className="absolute top-3 left-3 z-0 size-3 rounded-full bg-red-500 duration-300 group-hover:translate-x-4" />
    </div>
  );
}

export default Bullet;
