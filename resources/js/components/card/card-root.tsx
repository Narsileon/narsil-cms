import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type CardRootProps = ComponentProps<"div"> & {};

function CardRoot({ className, ...props }: CardRootProps) {
  return (
    <div
      data-slot="card-root"
      className={cn(
        "flex flex-col overflow-hidden rounded-xl border bg-card text-card-foreground shadow-sm",
        className,
      )}
      {...props}
    />
  );
}

export default CardRoot;
