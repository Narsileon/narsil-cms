import { Toggle } from "@base-ui/react/toggle";
import { toggleRootVariants } from "@narsil-cms/components/toggle";
import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import useToggleGroup from "./toggle-group-context";

type ToggleGroupItemProps = Toggle.Props & VariantProps<typeof toggleRootVariants>;

function ToggleGroupItem({ className, size, variant, ...props }: ToggleGroupItemProps) {
  const context = useToggleGroup();

  return (
    <Toggle
      data-slot="toggle-group-item"
      data-size={context.size || size}
      data-spacing={context.spacing}
      data-variant={context.variant || variant}
      className={cn(
        "shrink-0",
        "focus-visible:z-10",
        "focus:z-10",
        "group-data-[spacing=0]/toggle-group:px-2",
        "group-data-[spacing=0]/toggle-group:rounded-none",
        "group-data-horizontal/toggle-group:data-[spacing=0]:data-[variant=outline]:border-l-0",
        "group-data-horizontal/toggle-group:data-[spacing=0]:data-[variant=outline]:first:border-l",
        "group-data-horizontal/toggle-group:data-[spacing=0]:first:rounded-l-lg",
        "group-data-horizontal/toggle-group:data-[spacing=0]:last:rounded-r-lg",
        "group-data-vertical/toggle-group:data-[spacing=0]:data-[variant=outline]:border-t-0",
        "group-data-vertical/toggle-group:data-[spacing=0]:data-[variant=outline]:first:border-t",
        "group-data-vertical/toggle-group:data-[spacing=0]:first:rounded-t-lg",
        "group-data-vertical/toggle-group:data-[spacing=0]:last:rounded-b-lg",
        toggleRootVariants({
          size: context.size || size,
          variant: context.variant || variant,
        }),
        className,
      )}
      {...props}
    />
  );
}

export default ToggleGroupItem;
