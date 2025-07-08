import { cn } from "@/lib/utils";

type CardTitleProps = React.ComponentProps<"div"> & {};

function CardTitle({ className, ...props }: CardTitleProps) {
  return (
    <div
      data-slot="card-title"
      className={cn("leading-none font-semibold", className)}
      {...props}
    />
  );
}

export default CardTitle;
