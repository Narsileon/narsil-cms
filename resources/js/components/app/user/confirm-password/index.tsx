import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { route } from "ziggy-js";
import { useTranslationsStore } from "@/stores/translations-store";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogProps,
  DialogTitle,
} from "@/components/ui/dialog";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";

type UserConfirmPasswordProps = Required<
  Pick<DialogProps, "open" | "onOpenChange">
> & {
  onConfirmed: () => void;
};

function UserConfirmPassword({
  open,
  onConfirmed,
  onOpenChange,
}: UserConfirmPasswordProps) {
  const { trans } = useTranslationsStore();

  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <DialogHeader>
        <DialogTitle>{trans("passwords.confirming")}</DialogTitle>
      </DialogHeader>
      <DialogContent>
        <Form
          className="grid gap-6"
          method="post"
          options={{
            onSuccess: () => {
              onConfirmed();

              onOpenChange(false);
            },
          }}
          url={route("password.confirm")}
        >
          <FormField
            name="password"
            render={({ onChange, ...field }) => (
              <FormItem>
                <FormLabel required={true} />
                <Input
                  autoComplete="current-password"
                  type="password"
                  onChange={(e) => onChange(e.target.value)}
                  {...field}
                />
                <FormMessage />
              </FormItem>
            )}
          />
          <Button type="submit">{trans("ui.confirm")}</Button>
        </Form>
      </DialogContent>
    </Dialog>
  );
}

export default UserConfirmPassword;
