import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type CardRootProps = ComponentProps<"div">;

function CardRoot({ className, ...props }: CardRootProps) {
  return (
    <div
      data-slot="card-root"
      className={cn(
        "bg-card text-card-foreground flex flex-col overflow-hidden rounded-xl border shadow-sm",
        className,
      )}
      {...props}
    />
  );
}

export default CardRoot;
