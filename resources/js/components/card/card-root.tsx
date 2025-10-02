import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type CardRootProps = ComponentProps<"div"> & {};

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
