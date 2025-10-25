type BulletProps = {
  draft?: boolean;
  published?: boolean;
  saved?: boolean;
};

function Bullet({ draft = false, published = false, saved = false }: BulletProps) {
  return draft || published || saved ? (
    <div className="group relative h-9 w-full">
      {published ? (
        <div className={"absolute top-3 left-0 z-20 size-3 rounded-full bg-green-500"} />
      ) : null}
      {saved ? (
        <div className="absolute top-3 left-1.5 z-10 size-3 rounded-full bg-amber-500 duration-300 group-hover:translate-x-2" />
      ) : null}
      {draft ? (
        <div className="absolute top-3 left-3 z-0 size-3 rounded-full bg-red-500 duration-300 group-hover:translate-x-4" />
      ) : null}
    </div>
  ) : null;
}

export default Bullet;
