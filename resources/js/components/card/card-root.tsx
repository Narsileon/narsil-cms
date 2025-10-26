import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type CardRootProps = ComponentProps<"div">;

function CardRoot({ className, ...props }: CardRootProps) {
  return (
    <div
      data-slot="card-root"
      className={cn(
        "relative z-10 flex flex-col overflow-hidden rounded-xl border bg-card text-card-foreground shadow-sm",
        className,
      )}
      {...props}
    />
  );
}

export default CardRoot;
