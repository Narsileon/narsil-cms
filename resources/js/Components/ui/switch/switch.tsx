import { cn } from "@/Components";
import { Root, Thumb } from "@radix-ui/react-switch";

export type SwitchProps = React.ComponentProps<typeof Root> & {};

function Switch({ className, ...props }: SwitchProps) {
  return (
    <Root
      className={cn(
        "peer inline-flex h-[1.15rem] w-8 shrink-0 items-center rounded-full border border-transparent shadow-xs transition-all outline-none",
        "dark:data-[state=unchecked]:bg-input/80",
        "data-[state=checked]:bg-primary",
        "data-[state=unchecked]:bg-input",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
        className,
      )}
      data-slot="switch"
      {...props}
    >
      <Thumb
        className={cn(
          "bg-background pointer-events-none block size-4 rounded-full ring-0 transition-transform",
          "dark:data-[state=unchecked]:bg-foreground dark:data-[state=checked]:bg-primary-foreground",
          "data-[state=checked]:translate-x-[calc(100%-2px)] data-[state=unchecked]:translate-x-0",
        )}
        data-slot="switch-thumb"
      />
    </Root>
  );
}

export default Switch;
